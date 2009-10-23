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
 * Logikit File Helpers
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
* Sanitize an array
*
* @access       public
* @param        array  array
* @return	array
*/

function sanitize($array = '')
{
    if($array == '') $array = $_POST;

    foreach($array as $key => $value)
    {
        (is_array($value)) ? sanitize($value) : $array[$key] = doCallbacks($value);
    }
    
    return $array;
}

/**
* Call Callback functions
*
* @access       public
* @param        mixed  value
* @return	mixed
*/

function doCallbacks($value)
{
    $value = doEscape($value);
    return $value;
}

/**
* Escape
*
* @access       public
* @param        mixed  value
* @return	mixed
*/

function doEscape($value)
{
    $value = mysql_escape_string($value);
    return $value;
}


/**
 * unset any global variable that might cause problems
 */

unset($_SESSION['model'] , $_SESSION['helper'] , $_SESSION['library'] , $_SESSION['controller'] , $_SESSION['uri'] ,
      $_SESSION['view'] , $_SESSION['viewData'] , $_SESSION['template'] ,  $_SESSION['form']  ,  $_SESSION['validator'] ,
      $_SESSION['headers'] ,  $_SESSION['body'] , $_GET);


$arrayKeys = array_keys($_POST);
if(isset($arrayKeys[0])) sanitize();

/* End of file security.php 
   Location: ./system/helper/security.php */