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

class __CONTROLLER__ extends LogikitController
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

        $this->load->model('__CONTROLLER__Model');
        
        $recordCount = $this->__CONTROLLER__Model->count();
        
        loadPaginationScripts($this->_start , $this->_limit , $recordCount);
        
        $viewData['paginatorStr'] = generateAjaxPaginator($this->_limit , $recordCount);
        
        $this->load->view('index' , $viewData);
    }
    
    public function display()
    {
        $this->load->model('__CONTROLLER__Model');
        $id = getParameter('id');

        $viewData['record'] = $this->__CONTROLLER__Model->getById($id);
        $viewData['record']['date'] = $this->__CONTROLLER__Model->convertToEuropeanDate($viewData['record']['date']);
        $this->load->view('display' , $viewData);
    }
    
    public function delete()
    {
        $this->load->model('__CONTROLLER__Model');
        $id = getParameter('id');

        $this->__CONTROLLER__Model->delete($id);
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
            $this->load->model('__CONTROLLER__Model');
            $entry = $this->__CONTROLLER__Model->getById($id);
            
            if(isset($entry['date'])) $entry['date'] = $this->__CONTROLLER__Model->convertToEuropeanDate($entry['date']);
            
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
            $this->load->model('__CONTROLLER__Model');
            $recordSet = array();
            
            if($_POST['id'] != NULL) $recordSet['id'] = $_POST['id'];
            
    		$recordSet['title'] = $_POST['title'];
		$recordSet['entry'] = $_POST['entry'];
		$recordSet['date'] = $this->__CONTROLLER__Model->convertDate($_POST['date']);


            $this->__CONTROLLER__Model->populate($recordSet);
            $this->__CONTROLLER__Model->save();

            setFlashMessage('saved.');
        }
        
        echo json_encode($validationResult);
        
        exit;
    }
    
    public function paginator()
    {
        $this->load->model('__CONTROLLER__Model');
        $id = getParameter('id');

        $result = "    <div class=\"container\">
        <div class=\"row\">
__ITEMS__
            <div class=\"dungeon tableHeader\">
                Action
            </div>
        </div>
        ";

        $start = $_POST['start'];
        $limit = $_POST['limit'];
        $orderBy = $_POST['orderBy'];
        $order = $_POST['order'];

        $queryResult = $this->__CONTROLLER__Model->fetchAll(NULL , $orderBy . ' ' . $order , $limit , $start);
        foreach($queryResult as $row)
        {
            if(isset($row['date'])) $row['date'] = $this->EntriesModel->convertToEuropeanDate($row['date']);
            
            $result .= "<div class=\"row\">
__ROW_ITEMS__

            <div class=\"dungeon\">" .
            __ACTION_ITEMS__ .
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

// END __CONTROLLER__ class

/* End of file __CONTROLLER__.php 
   Location: ./system/application/controller/__CONTROLLER__.php */