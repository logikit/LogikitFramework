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
 * utility.php file
 *
 * Some useful functions.
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
* Set a namespace
*
* @access	    public
* @param        string  namespace
* @return	    boolean
*/

function setNamespace($namespace)
{
    return LogikitController::setNamespace($namespace);
    
    return TRUE;
}

/**
* Unset a namespace
*
* @access	    public
* @param        string  namespace
* @return	    boolean
*/

function unsetNamespace($namespace)
{
    return LogikitController::unsetNamespace($namespace);
    
    return TRUE;
}

/**
* Retrieve namespace values
*
* @access	    public
* @param            string    namespace
* @return	    array
*/

function getNamespaceValues($namespace)
{
    return $_SESSION[$namespace];
}

/**
* Retrieve namespace a value
*
* @access	    public
* @param            string    namespace
* @return	    mixed
*/

function getNamespaceValue($namespace)
{
    if(isset($_SESSION[$namespace][0])) return $_SESSION[$namespace][0]; else return false;
}

/**
* Add a value to a namespace
*
* @access	    public
* @param            string  namespace
* @param            string  value
* @return	    boolean
*/

function addToNamespace($namespace , $value)
{
    if(!in_array($value , $_SESSION[$namespace])) $_SESSION[$namespace][] = $value;

    return TRUE;
}

/**
* Retrieve controller name
*
* @access	    public
* @return	    string
*/

function getController()
{
    return getNamespaceValue('controller');
}

/**
* Retrieve action name
*
* @access	    public
* @return	    string
*/

function getAction()
{
    return getNamespaceValue('action');
}

/**
* Display a preformatted print_r()
*
* @access	    public
* @return	    string
*/

function printR($mixed)
{
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
    return true;
}

/* End of file utility.php 
   Location: ./system/logikit/utility.php */