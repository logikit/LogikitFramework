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
 * Logikit Core hook operations and cache manipulation
 *
 * Those functions are autoloaded during the code init. They are used to manipulate the output buffer to have script , css and code additions.
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

/**
 * Check if we will use a cached file.
 *
 * @access	public
 * @param       string  content : HTML output
 * @return	boolean
 */

function checkCache()
{
    
    $cacheFile = SYSTEMPATH . 'cache/' . base64_encode(serialize(getUri())) . '.html'; 

    $postKeys = array_keys($_POST);

    if(is_file($cacheFile) && time() - CACHE_PERIOD < filemtime($cacheFile) && !isset($_SESSION['flashMessageCount'][0]) && !isset($postKeys[0])) 
    {
        include($cacheFile); 
        exit; 
    }
}

/**
 * Write cache.
 *
 * @access	public
 * @param       string  content : HTML output
 * @return	boolean
 */

function writeCache($content)
{
    $cacheFile = SYSTEMPATH . 'cache/' .base64_encode(serialize(getUri())) . '.html';
    file_put_contents($cacheFile , $content);
    
    return TRUE;
}

if(ENABLE_CACHE == 1) checkCache();

?>