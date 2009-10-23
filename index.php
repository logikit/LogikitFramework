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
 * Logikit index.php file
 *
 * Defines required constants and loads Logikit Framework core.
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
 * Error Reporting
 *
 * Logikit::Framework's default for error reporting is E_ALL
 * This will display all the notices, warnings and fatal errors.
 *
 * You are advised to use error_reporting(0) on a live site.
 *
 * Visit http://www.php.net/error_reporting for more information.
 * 
 */


error_reporting(E_ALL);


/**
 * System Folder
 *
 * This is the folder where core Logikit Framework files stand.
 * Default is "system"
 * Change the value below if you will name this folder differently.
 * 
 */

$systemFolder = 'system';

/**
 * Application Folder
 *
 * This is the folder where core user application goes.
 * Default is "application"
 * Change the value below if you will name this folder differently.
 * 
 */

$applicationFolder = 'application';

define('FILEROOT' , dirname(__FILE__));
define('URLROOT' , 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/');
define('SYSTEMPATH' , FILEROOT . '/' . $systemFolder . '/');
define('APPLICATIONPATH' , FILEROOT . '/' . $applicationFolder . '/');

/**
 * As we are done with the system constants, we may include the application core.
 * 
 */

require SYSTEMPATH . 'logikit/logikit.php';

/* End of file index.php 
   Location: ./index.php */