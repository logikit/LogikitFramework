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
 * Logikit Validation Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

abstract class LogikitValidation
{
    public $result;
    private $_lang , $_validationOverAll = true , $_formItems = array();
    
    /**
    * Constructor
    *
    * 
    *
    */
    public function __construct()
    {
        if(LOAD_DEFAULT_LANGUAGE == TRUE)
        {
            include APPLICATIONPATH . 'language/' . $_SESSION['language'] . '/lang_error.php';
            $this->_lang = $lang;
        }
    }
    
    /**
    * Set the form object and validate form items
    *
    * @access	    public
    * @param        object    formObject
    * @return	    array
    */
    
    public function validateForm($formObject)
    {
        $this->form = new $formObject;
        $this->_setFormItems();
        
        $this->result['validationOverAll'] = $this->_validationOverAll;
        
        return $this->result;
    }
    
    /**
    * Set the form items
    *
    * @access	    public
    * @return	    boolean
    */
    
    private function _setFormItems()
    {
        $this->_formItems = $this->form->getItems();
        $this->validateAllItems();
        
        return TRUE;
    }
    
    /**
    * Validate a form item
    *
    * @access	    public
    * @param        array    item
    * @return	    boolean
    */

    public function checkValidation($item)
    {
        foreach($item['validation'] as $validationMethod)
        {
            preg_match_all('%(?:\[)(.*?)(\])%', $validationMethod , $paramsArray , PREG_PATTERN_ORDER);
            if(isset($paramsArray[0][0]))
            {
                $paramsString = $paramsArray[0][0];
                $params = explode(',' , substr(substr($paramsString , 1) , 0 , -1));
                $method = 'validate' . str_replace($paramsString , '' , ucfirst($validationMethod));
                if($this->$method($item , $params) == false) return false;
            }
            else
            {
                $method = 'validate' . $validationMethod;
                if($this->$method($item) == false) return false;                
            }
        }
        
        return true;
    }
    
    /**
    * Validate a form item
    *
    * @access	    public
    * @param        array    item
    * @return	    boolean
    */

    public function validateAllItems()
    {
        foreach($this->_formItems as $item)
        {
            if(isset($_POST[$item['name']]) && $item['type'] != 'submit' && $item['type'] != 'button'  && $item['validation'] != NULL)
            {
                $item['value'] = $_POST[$item['name']];
                if($validationResult = $this->checkValidation($item) == false)
                {
                    $this->_validationOverAll = false;
                }
            }
        }
    }

    /**
    * Check if a value is NULL
    *
    * @access	    public
    * @param        array    item
    * @return	    mixed
    */
    
    public function validateNotNull($item)
    {
        if($_POST[$item['name']] == NULL)
        {
            if(isset($this->_lang['error_notNull'])) $this->result[$item['name']] = $this->_lang['error_notNull'];
            else $this->result[$item['name']] = 'cannot be empty';
            
            return false;
        }
        else $this->result[$item['name']] = TRUE;
        
        return TRUE;
    }

    /**
    * Check if a value has of a valid email format
    *
    * @access	    public
    * @param        array    item
    * @return	    mixed
    */
    
    public function validateEmail($item)
    {
        if (eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $_POST[$item['name']])) 
           {
                if(isset($this->_lang['error_notEmail'])) $this->result[$item['name']] = $this->_lang['error_notEmail'];
                else $this->result[$item['name']] = 'not a valid email';
                
                return false;
           }
        else $this->result[$item['name']] = TRUE;
            
        return TRUE;
    }
    
    /**
    * Check if a value is greater than given parameter
    *
    * @access	    public
    * @param        array    item
    * @param        array    params
    * @return	    mixed
    */
    
    public function validateGreaterThan($item , $params)
    {
        if (!is_numeric($_POST[$item['name']]) || $_POST[$item['name']] <= $params[0])
        {
            if(isset($this->_lang['error_notGreaterThan'])) $this->result[$item['name']] = sprintf($this->_lang['error_notGreaterThan'] , $params[0]);
            else $this->result[$item['name']] = 'not greater than ' . $params[0];
            
            return false;
        }
        else $this->result[$item['name']] = TRUE;
            
        return TRUE;
    }
    
    /**
    * Check if a value is smaller than given parameter
    *
    * @access	    public
    * @param        array    item
    * @param        array    params
    * @return	    mixed
    */
    
    public function validateSmallerThan($item , $params)
    {
        if (!is_numeric($_POST[$item['name']]) || $_POST[$item['name']] >= $params[0])
        {
            if(isset($this->_lang['error_notSmallerThan'])) $this->result[$item['name']] = sprintf($this->_lang['error_notSmallerThan'] , $params[0]);
            else $this->result[$item['name']] = 'not smaller than ' . $params[0];
            
            return false;
        }   
        else $this->result[$item['name']] = TRUE;
            
        return TRUE;
    }
    
    /**
    * Check if a value is numeric
    *
    * @access	    public
    * @param        array    item
    * @return	    mixed
    */
    
    public function validateNumeric($item)
    {
        if (!is_numeric($_POST[$item['name']]))
        {
            if(isset($this->_lang['error_notNumeric'])) $this->result[$item['name']] = $this->_lang['error_notNumeric'];
            else $this->result[$item['name']] = 'not numeric';
        }
        else $this->result[$item['name']] = TRUE;
            
        return TRUE;
    }

    
}        

// END Validation class

/* End of file LogikitValidation.php 
   Location: ./system/library/LogikitValidation.php */