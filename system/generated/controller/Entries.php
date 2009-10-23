<?php

/**
 * Logikit::Framework
 *
 * Open source development framework for PHP 5
 *
 * @package		Logikit Framework
 * @author		Can Ince
 * @copyright	        Copyright (c) 2009, Logikit / Can Ince.
 * @license		http://www.opensource.org/licenses/mit-license.php

 * @link		http://framework.logikit.net
 */

class Entries extends LogikitController
{
    private $_start = 0, $_limit = 2; 
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $viewData = array();

        $this->load->systemHelper('ajax');

        $this->load->model('EntriesModel');
        
        $recordCount = $this->EntriesModel->count();
        
        loadPaginationScripts($this->_start , $this->_limit , $recordCount);
        
        $viewData['paginatorStr'] = generateAjaxPaginator($this->_limit , $recordCount);
        
        $this->load->view('index' , $viewData);
    }
    
    public function display()
    {
        $this->load->model('EntriesModel');
        $id = getParameter('id');

        $viewData['record'] = $this->EntriesModel->getById($id);
        $viewData['record']['date'] = $this->EntriesModel->convertToEuropeanDate($viewData['record']['date']);
        $this->load->view('display' , $viewData);
    }
    
    public function delete()
    {
        $this->load->model('EntriesModel');
        $id = getParameter('id');

        $this->EntriesModel->delete($id);
        setFlashMessage('deleted.');
        redirect(getController() . '/index');
    }
    
    public function edit()
    {
        $viewData = array();

        $this->load->form('EditForm');
        
        $id = getParameter('id' , -1);
        if($id != -1)
        {
            $this->load->model('EntriesModel');
            $entry = $this->EntriesModel->getById($id);
            
            if(isset($entry['date'])) $entry['date'] = $this->EntriesModel->convertToEuropeanDate($entry['date']);
            
            $this->EditForm->setValues($entry);
            $viewData['id'] = $id;
        }
       
        $viewData['formItems'] = $this->EditForm->renderAll();
        $this->load->systemHelper('ajax');
        ajaxValidate('form1');        
        $this->load->view("edit" , $viewData);
    }


    public function processForm()
    {
        $this->load->form('EditForm');
        $this->load->validator('EditFormValidator');
        
        $validationResult = $this->EditFormValidator->validateForm($this->EditForm);
        $validationResult['returnUrl'] = returnUrl('index');
        
        if($validationResult['validationOverAll'] == true)
        {
            $this->load->model('EntriesModel');
            $recordSet = array();
            
            if($_POST['id'] != NULL) $recordSet['id'] = $_POST['id'];
            
    		$recordSet['title'] = $_POST['title'];
		$recordSet['entry'] = $_POST['entry'];
		$recordSet['date'] = $this->EntriesModel->convertDate($_POST['date']);


            $this->EntriesModel->populate($recordSet);
            $this->EntriesModel->save();

            setFlashMessage('saved.');
        }
        
        echo json_encode($validationResult);
        
        exit;
    }
    
    public function paginator()
    {
        $this->load->model('EntriesModel');
        $id = getParameter('id');

        $result = "    <div class=\"container\">
        <div class=\"row\">
            <div class=\"dungeon tableHeader\">
                        <a href=\"javascript:changeOrder('title');\">Title</a>
            </div>
            <div class=\"dungeon tableHeader\">
                        <a href=\"javascript:changeOrder('entry');\">Entry</a>
            </div>
            <div class=\"dungeon tableHeader\">
                        <a href=\"javascript:changeOrder('date');\">Date</a>
            </div>

            <div class=\"dungeon tableHeader\">
                Action
            </div>
        </div>
        ";

        $start = $_POST['start'];
        $limit = $_POST['limit'];
        $orderBy = $_POST['orderBy'];
        $order = $_POST['order'];

        $queryResult = $this->EntriesModel->fetchAll(NULL , $orderBy . ' ' . $order , $limit , $start);
        foreach($queryResult as $row)
        {
            if(isset($row['date'])) $row['date'] = $this->EntriesModel->convertToEuropeanDate($row['date']);
            
            $result .= "<div class=\"row\">

                <div class=\"dungeon\">
                      " . $row['title'] . "
                </div>
                <div class=\"dungeon\">
                      " . $row['entry'] . "
                </div>
                <div class=\"dungeon\">
                      " . $row['date'] . "
                </div>

            <div class=\"dungeon\">" .
            siteLink(getController() . '/display/id/' . $row['id'] , 'display') . " | " .
            siteLink(getController() . '/edit/id/' . $row['id'] , 'edit') . " | " .
            siteLink(getController() . '/delete/id/' . $row['id'] , 'delete') .
        "</div>\n</div>";
        }
        echo $result;
        
        exit;
    }
    
    public function setPaginationLimit($limit)
    {
        return $_limit = $limit;
    }

}

// END Entries class

/* End of file Entries.php 
   Location: ./system/application/controller/Entries.php */