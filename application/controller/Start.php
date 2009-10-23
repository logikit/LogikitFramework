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

class Start extends LogikitController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $viewData = array();
        
        $this->load->view('index' , $viewData);
    }
    
    public function switchLanguage()
    {
        $newLanguage = getParameter('language' , DEFAULT_LANGUAGE);
        $this->Language->setLanguage($newLanguage);
        redirect('Start/language');
    }
    
    public function language()
    {
        $this->load->view('language');
    }
    
}

// END Controlpanel class

/* End of file Start.php 
   Location: ./system/application/controller/Start.php */