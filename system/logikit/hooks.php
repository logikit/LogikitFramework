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
 * Deal with caching.
 * Other stuff regarding output buffer features may also go here.
 *
 * @access	public
 * @param       string  content : HTML output
 * @return	string
 */

function hooks($content)
{
    if(ENABLE_CACHE) writeCache($content);
    
    return $content;
}

/**
 * Add a string to header.
 *
 * @access	public
 * @param       string  content
 * @param       string data
 * @return	string
 */

function _addHeaderData($content , $data)
{
    return str_replace('</head>' , $data . "\n</head>" , $content);
    return $content;
}

/**
 * Add a string to body.
 *
 * @access	public
 * @param       string  content
 * @param       string data
 * @return	string
 */
function _addBodyContent($content , $data)
{
    return str_replace('</body>' , $data . "\n</body>" , $content);
    return $content;
}

/**
 * Add a Javascript string to header.
 *
 * @access	public
 * @param       string  content
 * @param       string data
 * @return	string
 */
function _addHeaderScript($content , $data)
{
    $content = addHeaderData($content , '<script type="text/javascript" language="javascript" charset="utf-8">' . $data . '</script>');
    return $content;
}

/**
 * Load a Javascript file.
 *
 * @access	public
 * @param       string  content
 * @param       string path
 * @return	string
 */

function _loadHeaderScript($content , $path)
{
    $content = addHeaderData($content , '<script type="text/javascript" language="javascript" charset="utf-8" src="' .
                             URLROOT . 'javascript/' . $path . '.js"></script>');
    return $content;
}

/**
 * Load a Javascript file from logikitPublic directory.
 *
 * @access	public
 * @param       string  content
 * @param       string path
 * @return	string
 */

function _loadLogikitHeaderScript($content , $path)
{
    $content = addHeaderData($content , '<script type="text/javascript" language="javascript" charset="utf-8" src="' .
                             URLROOT . 'logikitPublic/javascript/' . $path . '.js"></script>');
    return $content;
}

/**
 * Load JQuery.
 *
 * @access	public
 * @param       string  content
 * @return	string
 */

function _loadJQuery($content)
{
    $content = loadLogikitHeaderScript ($content , 'jquery');
    return $content;
}

/**
 * Load JQuery Extensions.
 *
 * @access	public
 * @param       string  content
 * @param       array   extensionArray
 * @return	string
 */

function _loadJQueryExtensions($content , $extensionArray)
{
    foreach($extensionArray as $extension)
    {
        $content = loadLogikitHeaderScript($content , $extension);
    }
    
    return $content;
}

/**
 * Load a CSS file.
 *
 * @access	public
 * @param       string  content
 * @param       string   path
 * @return	string
 */

function _loadCSS($content , $path)
{
    $content = addHeaderData($content , '<link rel="stylesheet" href="' . URLROOT . 'css/' . $path . '.css" ' .
                          'type="text/css" media="all" charset="utf-8" />');
    return $content;
}

/**
 * Load a CSS file from logikitPublic directory.
 *
 * @access	public
 * @param       string  content
 * @param       string   path
 * @return	string
 */

function _loadLogikitCSS($content , $path)
{
    $content = addHeaderData($content , '<link rel="stylesheet" href="' . URLROOT . 'logikitPublic/css/' . $path . '.css.php?urlRoot=' . URLROOT . '" ' .
                          'type="text/css" media="all" charset="utf-8" />');
    return $content;
}

/**
 * Handle Flash message and display it if the page is changed.
 *
 * @access	public
 * @param       string  content
 * @return	string
 */

function _showFlashMessage($content)
{
    if(!isset($_SESSION['flashMessageCount'][0])) $_SESSION['flashMessageCount'][0] = 0;
    
    $_SESSION['flashMessageCount'][0]++ ;
    if($_SESSION['flashMessageCount'][0] == 2)
    {
        $scriptContent = '$(document).ready(function(){
            setTimeout(function(){
            $(".flash").fadeOut("slow", function () {
            $(".flash").remove();
                }); }, 2000);
           });';
        $content = _addHeaderScript($content , $scriptContent);
        $content = _addBodyContent($content , '<div class="flash onTop">' .  $_SESSION['flashMessage'][0] . '</div>');
        unset($_SESSION['flashMessage'][0]);
        unset($_SESSION['flashMessageCount']);
    }
    return $content;

}

/* End of file hooks.php 
   Location: ./system/logikit/hooks.php */