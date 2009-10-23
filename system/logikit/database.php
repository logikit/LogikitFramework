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
 * Logikit Core database file
 *
 * Includes CoughPHP ORM and initiates the database connection.
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

require(SYSTEMPATH . 'coughphp/load.inc.php');
require(SYSTEMPATH . 'coughphp/as_database/load.inc.php');

CoughDatabaseFactory::addConfig($dsn);

/* End of file database.php 
   Location: ./system/logikit/database.php */