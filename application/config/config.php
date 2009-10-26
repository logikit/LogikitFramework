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
 * Logikit configuration file
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
 * Controller
 *
 * Sets the default controller
 * Change the value below if you want to name the default controller differently.
 * 
 * *** Controller names are CASE_SENSITIVE. They must start with a capital. The rest must be lowercase***
 * *** Examples : Main , Ftp , User 
 * 
 */

$defaultController = 'Start';

// ------------------------------------------------------------------------
/**
 * Action
 *
 * Sets the default action
 * Change the value below if you want to name the default action differently.
 * 
 * *** Action names are CASE_SENSITIVE. ***
 * 
 */

$defaultAction = 'index';

// ------------------------------------------------------------------------
/**
 * Template
 *
 * Sets the default template
 * Change the value below if you want to name the default template differently.
 * 
 */

$defaultTemplate = 'main';

// ------------------------------------------------------------------------
/**
 * Define system constants
 */
// ------------------------------------------------------------------------

/**
 *
 * Database environment.
 * Database connection settings are handled in application/config/database.ini file.
 * 
 * define("DB_ENVIRONMENT" , 'none'); // do not use a database
 * define("DB_ENVIRONMENT" , 'development'); // use "development" DSN
 * define("DB_ENVIRONMENT" , 'production'); // use "production" DSN
*/

define("DB_ENVIRONMENT" , 'none');


/**
 *
 * Error reporting. Turn it "FALSE" not to display errors
 * 
*/

define("ERROR_REPORTING" , TRUE);

/**
 *
 * Warning reporting. Turn it "FALSE" not to display errors
 * 
*/

define("WARNING_REPORTING" , TRUE);

// ------------------------------------------------------------------------
/**
 *
 * Cache. Turn it "TRUE" to use the cache
 * Remember to set system/cache directory writable.
 * 
*/

define("ENABLE_CACHE" , FALSE);


/**
 *
 * Cache Period. Set the caching period in seconds, if ENABLE_CACHE constant above is set to "TRUE"
 * 
*/

define("CACHE_PERIOD" , 5);

// ------------------------------------------------------------------------
/**
 *
 * Load JQuery.
 * JQuery is a javascript library. Logikit::Framework make use of it especially for ajax purposes.
 * You are advised to keep the default setting.
 * 
 * See http://jquery.com/ for more information.
 *
 * If you will not have javascript/ajax related jobs you can turn it FALSE.
 * 
*/

define("LOAD_JQUERY" , TRUE);


// ------------------------------------------------------------------------
/**
 *
 * Default language file. Turn it "FALSE" if you will not use i18n and l10n features.
 * 
*/

define("LOAD_DEFAULT_LANGUAGE" , TRUE);

/**
 *
 * Default language folder to be loaded if LOAD_DEFAULT_LANGUAGE constant above is set to "TRUE".
 * 
*/

define("DEFAULT_LANGUAGE" , 'en');

/**
 *
 * Default language file to be loaded if LOAD_DEFAULT_LANGUAGE constant above is set to "TRUE".
 * The path to file to be loaded is APPLICATIONPATH . 'language/' .  DEFAULT_LANGUAGE . '/lang_' . DEFAULT_LANGUAGE_FILE . '.php'
 * Ex: application/language/en/lang_main.php
 * be sure not to remove this file if you plan to use i18n and l10n features.
 * 
*/

define("DEFAULT_LANGUAGE_FILE" , 'main');

/* End of file config.php 
   Location: ./application/config/config.php */