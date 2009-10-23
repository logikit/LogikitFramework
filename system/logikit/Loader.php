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
 * Loader Class
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

class Loader
{
   
    /**
    * Constructor
    *
    * Set namespaces and call the loader
    *
    */
   
    public function __construct()
    {
        
    }
    
    /**
    * Load a model
    *
    * @access	    public
    * @param        string  modelToBeLoaded
    * @return	    object
    */
    
    public function model($modelToBeLoaded)
    {
        if($this->_isLoaded('model' , $modelToBeLoaded)) triggerWarning('Model ' . $modelToBeLoaded . 'already loaded');
        
        require APPLICATIONPATH . 'model/' . $modelToBeLoaded . '.php';
        
        //check if the model is in a subdir
        
        $dirName = dirname($modelToBeLoaded);
        if($dirName != '.')
        {
            $modelToBeLoaded = basename($modelToBeLoaded);
        }
        $loadedModel = new $modelToBeLoaded();
        
        $LCInstance = getInstance();
        
        $LCInstance->$modelToBeLoaded = $loadedModel;        
        
        $this->registerExtension('model' , $modelToBeLoaded);
        
        return $loadedModel;
    }
    
    /**
    * Load a library
    *
    * @access	    public
    * @param        string  libraryToBeLoaded
    * @return	    object
    */
    
    public function library($libraryToBeLoaded)
    {
        if($this->_isLoaded('library' , $libraryToBeLoaded)) triggerError('Library ' . $libraryToBeLoaded . 'already loaded');
        
        require(APPLICATIONPATH . 'library/' . $libraryToBeLoaded . '.php');
        
        //check if the library is in a subdir
        
        $dirName = dirname($libraryToBeLoaded);
        if($dirName != '.')
        {
            $libraryToBeLoaded = basename($libraryToBeLoaded);
        }        
        $loadedLibrary = new $libraryToBeLoaded();
        
        $LCInstance = getInstance();
        
        $LCInstance->$libraryToBeLoaded = $loadedLibrary;
        
        $this->registerExtension('library' , $libraryToBeLoaded);
        
        return $loadedLibrary;
    }
    
    /**
    * Load a library from the system folder
    *
    * @access	    public
    * @param        string  libraryToBeLoaded
    * @return	    object
    */
    
    public function systemLibrary($libraryToBeLoaded)
    {
        if($this->_isLoaded('library' , $libraryToBeLoaded)) triggerError('Library ' . $libraryToBeLoaded . 'already loaded');
        
        require(SYSTEMPATH . 'library/' . $libraryToBeLoaded . '.php');
        
        $loadedLibrary = new $libraryToBeLoaded();
        
        $LCInstance = getInstance();
        
        $LCInstance->$libraryToBeLoaded = $loadedLibrary;
        
        $this->registerExtension('library' , $libraryToBeLoaded);
        
        return $loadedLibrary;
    }
    
    /**
    * Load a view
    *
    * @access	    public
    * @param        string  viewToBeLoaded
    * @param        array   viewData
    * @return	    boolean
    */
    
    public function view($viewToBeLoaded , $viewData = '')
    {   
        $this->registerExtension('view' , $viewToBeLoaded);
        if($viewData != '') $this->registerExtension('viewData' , $viewData);
        
        return TRUE;
    }
    
    /**
    * Load a helper
    *
    * @access	    public
    * @param        string  helperToBeLoaded
    * @return	    boolean
    */
    
    public function helper($helperToBeLoaded)
    {
        if($this->_isLoaded('helper' , $helperToBeLoaded)) triggerError('Helper ' . $helperToBeLoaded . 'already loaded');
        
        require(APPLICATIONPATH . 'helper/' . $helperToBeLoaded . '.php');
        
        $this->registerExtension('helper' , $helperToBeLoaded);
        
        return TRUE;
    }
    
    /**
    * Load a helper from the system folder
    *
    * @access	    public
    * @param        string  helperToBeLoaded
    * @return	    boolean
    */
    
    public function systemHelper($helperToBeLoaded)
    {
        if($this->_isLoaded('helper' , $helperToBeLoaded)) die('Helper ' . $helperToBeLoaded . 'already loaded');
        
        require(SYSTEMPATH . 'helper/' . $helperToBeLoaded . '.php');
        
        $this->registerExtension('helper' , $helperToBeLoaded);
        
        return TRUE;
    }
    
    /**
    * Load a form
    *
    * @access	    public
    * @param        string  formToBeLoaded
    * @return	    object
    */
    
    public function form($formToBeLoaded)
    {
        require_once(SYSTEMPATH . 'library/LogikitForm.php');

        if($this->_isLoaded('form' , $formToBeLoaded)) triggerError('Form ' . $formToBeLoaded . 'already loaded');

        require(APPLICATIONPATH . 'form/' . getController() . '/' . $formToBeLoaded . '.php');
        
        $loadedForm = new $formToBeLoaded();
        
        $LCInstance = getInstance();
        
        $LCInstance->$formToBeLoaded = $loadedForm;
        
        $this->registerExtension('form' , $formToBeLoaded);
        
        return $loadedForm;
    }
    
    /**
    * Load a validator
    *
    * @access	    public
    * @param        string  validatorToBeLoaded
    * @return	    object
    */
    
    public function validator($validatorToBeLoaded)
    {
        require_once(SYSTEMPATH . 'library/LogikitValidation.php');

        if($this->_isLoaded('form' , $validatorToBeLoaded)) triggerError('Validator ' . $validatorToBeLoaded . 'already loaded');

        require(APPLICATIONPATH . 'validator/' . getController() . '/' . $validatorToBeLoaded . '.php');
        
        $loadedValidator = new $validatorToBeLoaded();
        
        $LCInstance = getInstance();
        
        $LCInstance->$validatorToBeLoaded = $loadedValidator;
        
        $this->registerExtension('validator' , $validatorToBeLoaded);
        
        return $loadedValidator;
    }
    
    /**
    * Checks if the given extension is loaded
    *
    * @access	    public
    * @param        string  extensionType
    * @param        string  extensionName
    * @return	    boolean
    */
    
    protected function _isLoaded($extensionType , $extensionName)
    {
        if(in_array($extensionName , $_SESSION[$extensionType])) return TRUE;
        
        return FALSE;
    }
    
    /**
    * Registers an extension
    *
    * @access	    public
    * @param        string  extensionType
    * @param        string  extensionName
    * @return	    boolean
    */
    
    public function registerExtension($extensionType , $extensionName)
    {
        $this->addToNamespace($extensionType , $extensionName);
    }
    
    /**
    * Add a value to a namespace
    *
    * @access	    public
    * @param        string  namespace
    * @param        string  value
    * @return	    boolean
    */
    
    public function addToNamespace($namespace , $value)
    {
        if(!in_array($value , $_SESSION[$namespace])) $_SESSION[$namespace][] = $value;
    }
    
    
}
// END Loader class

/* End of file Loader.php 
   Location: ./system/logikit/Loader.php */