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

class Users extends LogikitController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $viewData = array();

        $this->load->model('UsersModel');

        $viewData['recordSet'] = $this->UsersModel->fetchAll();

        $this->load->view('index' , $viewData);
    }
    
    public function display()
    {
        $this->load->model('UsersModel');
        $id = getParameter('id');

        $viewData['record'] = $this->UsersModel->getById($id);
        $this->load->view('display' , $viewData);
    }
    
    public function delete()
    {
        $this->load->model('UsersModel');
        $id = getParameter('id');

        $this->UsersModel->delete($id);
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
            $this->load->model('UsersModel');
            $entry = $this->UsersModel->getById($id);
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
            $this->load->model('UsersModel');
            $recordSet = array();
            
            if($_POST['id'] != NULL) $recordSet['id'] = $_POST['id'];
            
    		$recordSet['username'] = $_POST['username'];
		$recordSet['password'] = $_POST['password'];


            $this->UsersModel->populate($recordSet);
            $this->UsersModel->save();

            setFlashMessage('saved.');
        }
        
        echo json_encode($validationResult);exit;
    }

}

// END Users class

/* End of file Users.php 
   Location: ./system/application/controller/Users.php */