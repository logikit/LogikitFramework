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
 * Language Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

class Language
{
    protected $_permsTotal , $_dirs;
    
    /**
    * Constructor
    *
    * 
    *
    */
    
    public function __construct()
    {
        $this->_dirs = array('system/generated' , 'system/cache' , 'application/config');
    }
    
    /**
    * Set default language
    *
    * @access	    private
    * @param        string  string
    * @return	    boolean
    */
    
    private function _displayOK($string)
    {
        $this->_permsTotal ++ ;
        return '<span class="ok">' . $string . '</span>';
    }
    
    /**
    * Set language
    *
    * @access	    public
    * @param        string  language
    * @return	    string
    */
    
    public function setLanguage($language)
    {
        $_SESSION['language'] = $language;
    }
    
    /**
    * Load a language file
    *
    * @access	    public
    * @param        string  fileName
    * @return	    array
    */
    
    public function loadLanguage($fileName = 'main')
    {
        if(!isset($_SESSION['language'])) triggerWarning("Language is not set.");
        
        $languageFile = APPLICATIONPATH . 'language/' .  $_SESSION['language'] . '/lang_' . $fileName . '.php';
        
        if(!is_file($languageFile))
        {
            triggerWarning("Cannot locate language file.");
            $languageFile = APPLICATIONPATH . 'language/' .  $_SESSION['language'] . '/lang_main.php';
            if(!is_file($languageFile))
            {
                triggerWarning("Cannot locate language file.");
                $languageFile = APPLICATIONPATH . 'language/en/lang_main.php';
                if(!is_file($languageFile))
                {
                    triggerError("Cannot locate language file.");
                }
            }
        }
        
        require_once $languageFile;
        
        return $lang;
    }
    
}
// END Language class

/* End of file Language.php 
   Location: ./system/library/Language.php */