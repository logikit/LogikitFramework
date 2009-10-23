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
 * Logikit System Message Helpers
 *
 * @package		Logikit Framework
 * @subpackage	        Helpers
 * @category	        Helpers
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
 * Display a warning message
 *
 * @access	public
 * @param	string	message
 * @return	boolean
 */	

function triggerWarning($message)
{
    if(WARNING_REPORTING == TRUE) echo '<div class="warning">'.$message.'</div>';
    
    return TRUE;
}

/**
 * Display an error message and exit
 *
 * @access	public
 * @param	string	message
 */

function triggerError($message)
{
    if(ERROR_REPORTING == TRUE) echo '<div class="error">'.$message.'</div>';
    
    exit;
}

/**
 * Display a message
 *
 * @access	public
 * @param	string	message
 * @return      string
 */

function message($message)
{
     return '<div class="info">'.$message.'</div>';
}

/**
 * Display an error message
 *
 * @access	public
 * @param	string	message
 * @return      string
 */

function errorMessage($message)
{
     return '<div class="error">'.$message.'</div>';
}

/**
 * Set a "flash message"
 *
 * @access	public
 * @param	string	message
 * @return	boolean
 */

function setFlashMessage($message)
{
    $_SESSION['FlashMessage'][0] = '<div class="info">'.$message.'</div>';
    
    return TRUE;
}

/**
 * Set a "flash message" to be displayed at the next screen
 *
 * @access	public
 * @param	string	message
 * @return	boolean
 */

function setFlashMessageNext($message)
{
    define('NEXTMESSAGE' , $message);
}

?>