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
 * Logikit Error handling
 *
 * @package		Logikit Framework
 * @subpackage	        Helpers
 * @category	        Helpers
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
 * Display an error or warning message
 *
 * @access	public
 * @param	string	message
 * @return	boolean
 */	

function LogikitErrorHandler($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
    case E_USER_ERROR:
        $errorContent =  "<b>ERROR</b>$errstr<br />\n";
        $errorContent .= "  Fatal error on line $errline in file $errfile";
        $errorContent .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $errorContent .= "Aborting...<br />\n";
        triggerError($errorContent);
        exit(1);
        break;

    case E_USER_WARNING:
    case 2:
        
        //file helper checks write permissions trying to write a test file into a directory and this may return an unsuppressable warning.
        if(!strstr($errfile , '/system/helper/file.php')) triggerWarning("<b>WARNING:</b> $errstr line: $errline file: $errfile<br />\n");
        break;

    case 8:
    case E_USER_NOTICE:
        triggerWarning("<b>NOTICE:</b> $errstr line: $errline file: $errfile<br />\n");
        break;

    default:
        echo "Unknown error type: [$errno] $errstr line: $errline file: $errfile<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return TRUE;
}

set_error_handler("LogikitErrorHandler");

?>