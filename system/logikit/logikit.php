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
 * Logikit logikit.php file
 *
 * Logikit::Framework core file.
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------


session_start();
/**
 * initialize the system
 */

require(APPLICATIONPATH . 'config/config.php');

require(SYSTEMPATH . 'logikit/LogikitController.php');
require(SYSTEMPATH . 'logikit/utility.php');
require(SYSTEMPATH . 'helper/form.php');
require(SYSTEMPATH . 'helper/uri.php');
require(SYSTEMPATH . 'helper/cache.php');
require(SYSTEMPATH . 'helper/security.php');
require(SYSTEMPATH . 'helper/messages.php');
require(SYSTEMPATH . 'helper/errorReporting.php');
require(SYSTEMPATH . 'helper/file.php');

if(DB_ENVIRONMENT != 'none') require(SYSTEMPATH . 'model/LogikitModel.php');
//require(SYSTEMPATH . 'logikit/database.php');
require(APPLICATIONPATH . 'config/autoload.php');
require(SYSTEMPATH . 'helper/view.php');
require(SYSTEMPATH . 'logikit/router.php');
require(SYSTEMPATH . 'logikit/hooks.php');

/**
 * run the controller
 */

$$currentController->load->registerExtension('controller' , $currentController);

/**
 * set template
 */

$$currentController->setTemplate($defaultTemplate);

/**
 * run the action
 */

$$currentController->$currentAction();

/**
 * serve it
 */
$$currentController->renderTemplate();

/**
 * handle flash messages for the next screen
 */

if(defined('NEXTMESSAGE'))
{
    setFlashMessage(NEXTMESSAGE);
}
else
{
    unset($_SESSION['FlashMessage'][0]);
}

/* End of file logikit.php 
   Location: ./system/logikit/logikit.php */