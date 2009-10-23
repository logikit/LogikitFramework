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

// ------------------------------------------------------------------------

/**
 * Main Controller Class
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

require(SYSTEMPATH . 'logikit/Loader.php');

abstract class LogikitController
{
    public $registeredExtensions = array() , $uri;
    
    private $reservedNamespaces = array('model' , 'controller' , 'helper' , 'library' , 'uri' , 'view' , 'viewData' , 'template' , 'language' , 'form' , 'headers' , 'body');
    
    private static $instance;
    
    /**
    * Constructor
    *
    * Set namespaces and call the loader
    *
    */
    
    public function __construct()
    {

        
        LogikitController::setNamespace('model');
        LogikitController::setNamespace('helper');
        LogikitController::setNamespace('library');
        LogikitController::setNamespace('controller');
        LogikitController::setNamespace('uri');
        LogikitController::setNamespace('view');
        LogikitController::setNamespace('viewData');
        LogikitController::setNamespace('template');
        if(!isset($_SESSION['FlashMessage'])) LogikitController::setNamespace('FlashMessage');
        LogikitController::setNamespace('form');
        LogikitController::setNamespace('validator');
        LogikitController::setNamespace('headers');
        LogikitController::setNamespace('body');
        
        if(LOAD_JQUERY == TRUE) loadJquery();
        
        self::$instance = $this;

        $this->load = new Loader();
        if(defined('LOAD_DEFAULT_LANGUAGE') && LOAD_DEFAULT_LANGUAGE == TRUE)
        {
            $this->load->systemLibrary("Language");
            (!isset($_SESSION['language'])) ? $this->Language->setLanguage(DEFAULT_LANGUAGE) : $this->Language->setLanguage($_SESSION['language']);
            $this->lang = $this->Language->loadLanguage(DEFAULT_LANGUAGE_FILE);
        }
    }

    /**
    * Get an instance of LogikitController Object
    *
    * @access	    public
    * @param        string  extensionsToBeLoaded
    * @return	    boolean
    */
    
    public static function getInstance()
    {
        return self::$instance;
    }
    
    /**
    * Loads the extensions set to be autoloaded
    *
    * @access	    public
    * @param        string  extensionsToBeLoaded
    * @return	    boolean
    */
    
    public function autoLoad($extensionsToBeLoaded)
    {
        //Load models
        if(isset($extensionsToBeLoaded['model']) && is_array($extensionsToBeLoaded['model']))
        foreach($extensionsToBeLoaded['model'] as $modelToBeLoaded)
        {
            $this->$modelToBeLoaded = $this->load->model($modelToBeLoaded);
        }
        
        //Load libraries
        if(isset($extensionsToBeLoaded['library']) && is_array($extensionsToBeLoaded['library']))
        foreach($extensionsToBeLoaded['library'] as $libraryToBeLoaded)
        {
            $this->$libraryToBeLoaded = $this->load->library($libraryToBeLoaded);
        }
        
        define('CORE_EXTENSIONS_LOADED' , TRUE);
        
        return TRUE;
    }
    
    /**
    * Set a namespace
    *
    * @access	    public
    * @param        string  namespace
    * @return	    boolean
    */
    
    public static function setNamespace($namespace)
    {
        if(defined('CORE_EXTENSIONS_LOADED'))
        {
            $instance = getInstance();
            if(in_array($namespace , $instance->reservedNamespaces))
            {
                triggerWarning($namespace . ' is a reserved namespace');
                return FALSE;
            }
        }
        $_SESSION[$namespace] = array();
        
        return TRUE;
    }
    
    /**
    * Unset a namespace
    *
    * @access	    public
    * @param        string  namespace
    * @return	    boolean
    */
    
    public static function unsetNamespace($namespace)
    {
        if(defined('CORE_EXTENSIONS_LOADED'))
        {
            $instance = getInstance();
            if(in_array($namespace , $instance->reservedNamespaces))
            {
                triggerWarning($namespace . ' is a reserved namespace');
                return FALSE;
            }
        }
        unset($_SESSION[$namespace]);
        
        return TRUE;
    }
    
    /**
    * Set the template
    *
    * @access	    public
    * @param        string  template
    * @return	    boolean
    */
    
    public function setTemplate($template)
    {
        $this->load->registerExtension('template' , $template);
        return TRUE;
    }
    
    /**
    * Render the template
    *
    * @access	    public
    * @return	    boolean
    */
    
    public function renderTemplate()
    {
        header('Content-Type: text/HTML; charset=UTF-8');
        ob_start("hooks");
        
        $template = $_SESSION['template'][0];
        $templateFile = APPLICATIONPATH . 'template/' . $template . '.php';
        if(!is_file($templateFile)) triggerError('Template "' . $templateFile . '" could not be loaded.');
        
        require $templateFile;
        ob_end_flush();

        return TRUE;
    }
    
    /**
    * Render the view
    *
    * @access	    public
    * @return	    boolean
    */
    
    public function renderView()
    {
        if(!isset($_SESSION['view'][0]))
        {
            triggerWarning("Cannot load view.");
            return FALSE;
        }
        
        $view = $_SESSION['view'][0];
        $viewFile = APPLICATIONPATH . 'view/' . $_SESSION['controller'][0] . '/'. $view . '.php';
        if(!is_file($viewFile)) triggerError('View "' . $viewFile . '" could not be loaded.');
        if(isset($_SESSION['viewData'][0])) extract($_SESSION['viewData'][0]);
        
        require $viewFile;
        
        return TRUE;
    }

}
// END LogikitController class


function getInstance()
{
    return LogikitController::getInstance();
}

/* End of file LogikitController.php 
   Location: ./system/logikit/LogikitController.php */