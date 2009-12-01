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
 * Logikit Form Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

abstract class LogikitForm
{
    private $_formItems = array();
    
    /**
    * Constructor
    *
    * 
    *
    */
    
    public function __construct()
    {

    }
    
    /**
    * Add a form item
    *
    * @access	    public
    * @param        array    item
    * @return	    boolean
    */

    public function addItem($item)
    {
        $this->_formItems[$item['name']] = $item;
        
        return TRUE;
    }
    
    /**
    * Remove a form item
    *
    * @access	    public
    * @param        string    itemName
    * @return	    boolean
    */

    public function removeItem($itemName)
    {
        unset($this->_formItems[$itemName]);
        
        return TRUE;
    }
    
    /**
    * Set value to a form item
    *
    * @access	    public
    * @param        string   itemName
    * @param        mixed    value
    * @return	    boolean
    */

    public function setValue($itemName , $value = '')
    {
        $this->_formItems[$itemName]['value'] = $value;

        return TRUE;
    }
    
    /**
    * Set values to form items
    *
    * @access	    public
    * @param        array   array
    * @return	    boolean
    */
    
    public function setValues($array)
    {
        foreach($array as $key => $value)
        {
            if(isset($this->_formItems[$key]))
            {
                $type = $this->getType($this->_formItems[$key]);
                if($type == 'radio' || $type == 'selectBox')
                {
                    $this->setSelected($key , $value);
                }
                else
                {
                    $this->setValue($key , $value);
                }
            }
        }
        return true;
    }

    /**
    * Get the value of a form item
    *
    * @access	    public
    * @param        string   $itemName
    * @return	    mixed
    */
    
    public function getValue($itemName)
    {
        return $this->_formItems[$itemName]['value'];
    }
    
    /**
    * Get the type of a form item
    *
    * @access	    public
    * @param        string   itemName
    * @return	    string
    */
    
    public function getType($itemName)
    {
        return $this->_formItems[$itemName['name']]['type'];
    }
    
    /**
    * Set value as selected for a form item
    *
    * @access	    public
    * @param        string   itemName
    * @param        mixed    selected
    * @return	    boolean
    */

    public function setSelected($itemName , $selected = '')
    {
        $this->_formItems[$itemName]['selected'] = $selected;

        return TRUE;
    }
    
   /**
    * Add an option an item
    *
    * @access	    public
    * @param        string   itemName
    * @param        array  option
    * @return	    boolean
    */

    public function addOption($itemName , $option)
    {
        $arrayKeys = array_keys($option);
        $arrayValues = array_values($option);
        $optionValue = $arrayKeys[0];
        $optionText = $arrayValues[0];
        
        $this->_formItems[$itemName]['options'][$optionValue] = $optionText;
        
        return TRUE;
    }
    
    /**
    * Retrieve form items
    *
    * @access	    public
    * @return	    array
    */

    public function getItems()
    {
        return $this->_formItems;
    }

    /**
    * Render all items
    *
    * @access	    public
    * @param        string  itemName
    * @return	    string
    */

    public function renderAll()
    {
        $result = array();
        foreach($this->_formItems as $item)
        {
            $result[$item['name']] = $this->render($item['name']);
        }
        
        return $result;
    }
   
    /**
    * Render item
    *
    * @access	    public
    * @param        string  itemName
    * @return	    string
    */

    public function render($itemName)
    {
        $item = $this->_formItems[$itemName];
        
        $renderMethod = 'render' . ucfirst($item['type']);

        return $this->$renderMethod($item); 
    }
    
    /**
    * Render a textbox
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderTextBox($item)
    {
        return '<input type="text" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }

    /**
    * Render a password box
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */
    
    public static function renderPassword($item)
    {
        return '<input type="password" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }
    
    /**
    * Render a hidden value
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderHidden($item)
    {
        if(!isset($item['properties'])) $item['properties'] = '';
        
        return '<input type="hidden" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }

    /**
    * Render a submit button
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */
    
    public static function renderSubmit($item)
    {
        return '<input type="submit" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }
    
    /**
    * Render a file upload button
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */
    
    public static function renderFile($item)
    {
        return '<input type="file" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }
    
    /**
    * Render a textarea
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderTextArea($item)
    {
        return '<textarea id="' . $item['name'] . '" name="' . $item['name'] . '" ' . $item['properties'] .
        '>' . $item['value'] . '</textarea>';
    }
    
    /**
    * Render a button
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderButton($item)
    {
        return '<button id="' . $item['name'] . '" name="' . $item['name'] . '" ' . $item['properties'] .
        '>' . $item['value'] . '</button>';
    }
    
    /**
    * Render a selectbox
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderSelectBox($item)
    {
        $result = '<select id="' . $item['name'] . '" name="' . $item['name'] . '" ' . $item['properties'] .
        '>' . "\n";
        if(isset($item['selected']) && $item['selected'] != NULL)
        {
            $result .= '<option value="' . $item['selected'] . '" selected="selected">' . $item['options'][$item['selected']] . '</option>' . "\n";
        }
        else
        {
            $result .= '<option value="' .$item['options'][0]['value'] . '" selected="selected">' . "\n";
        }
        foreach($item['options'] as $key => $option)
        {
            if($key != $item['selected'])
            {
                $result .= '<option value="' . $key. '">' . $option . '</option>' . "\n";
            }
        }
        $result .= '</select>' . "\n";
        
        return $result;
    }
    
    
    /**
    * Render a radio button
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderRadio($item)
    {
        $result = '<ul class="radio' . $item['name'] . '">';

        foreach($item['options'] as $key => $option)
        {

            $result .= '<li><input type="radio" name="' . $item['name'] . '" value="' . $key
            . '" ';
            
            if(isset($item['selected']) && $item['selected'] == $key)
            {
                $result .= ' checked="checked" ';
            }
            
            $result .= '/>' . $option . '</li>' . "\n";
            
        }
        $result .= '</ul>' . "\n";
        
        return $result;
    }
    
    /**
    * Render a JQuery DatePicker
    *
    * Requires Jquery.
    * in config/config.php file, LOAD_JQUERY should be TRUE and logikitPublic/javascript directory should be intact. 
    *
    * @access	    public
    * @param        array  item
    * @return	    string
    */

    public static function renderDatePicker($item)
    {
        if(LOAD_JQUERY == false)
        {
            triggerWarning("Set LOAD_JQUERY TRUE in config.php to use this DatePicker component.");
        }
        loadLogikitCSS('jquery.datepick.css');
        loadLogikitScript('jquery.datepick.js');
        addScript("$(function() {
                $('#". $item['name'] ."').datepick();
                });");
        return '<input type="text" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" '
        . $item['properties'] . ' />';
    }
    
}        

// END Form class

/* End of file LogikitForm.php 
   Location: ./system/library/LogikitForm.php */