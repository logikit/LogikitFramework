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
 * Logikit Form Helpers
 * 
 * Those functions are autoloaded during the code init.
 *
 * @package		Logikit Framework
 * @subpackage	        Helpers
 * @category	        Helpers
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
* Generate form open tag
*
* @access       public
* @param        string  name
* @param        string  action
* @param        string  method
* @param        string  properties
* @param        string  target
* @return       string
*/

function formOpen($name = NULL , $action = NULL , $method = 'POST' , $properties = NULL , $target = NULL)
{
    $result = '<form name="' . $name .'" id="' . $name .'" method="' . $method . '" action="' . $action . '" '. $properties . ' ';
    
    if($target != NULL)
    {
        $result .= ' target="' . $target . '" ';
    }
    
    $result .= '>';

    return $result;
}

/**
* Form open tag with "multipart/form-data"
*
* @access       public
* @param        string  name
* @param        string  action
* @param        string  method
* @param        string  properties
* @param        string  target
* @return       string
*/

function formOpenMultipart($name = NULL , $action = NULL , $method = 'POST' , $properties = NULL , $target = NULL)
{
    $result = '<form enctype="multipart/form-data" name="' . $name .'" id="' . $name . '" method="' . $method . '" action="' . $action . '" '. $properties . ' ';
    
    if($target != NULL)
    {
        $result .= ' target="' . $target . '" ';
    }
    
    $result .= '>';

    return $result;
}

/**
* Form close tag
*
* @access       public
* @return       string
*/

function formClose()
{
    return '</form>';
}

?>