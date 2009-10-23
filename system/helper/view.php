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
 * Logikit View Helpers
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
 * Create a pre-formatted anchor 
 *
 * @access	public
 * @param       string  $target
 * @param       string  $text
 * @param       string $params
 * @return	string
 */

function siteLink($target , $text , $params = '')
{
    return '<a href="' . URLROOT . $target . '" ' . $params . '>' . $text . '</a>';
}

/**
 * Create a pre-formatted URI 
 *
 * @access	public
 * @param       string  $target
 * @return	string
 */

function siteUri($target)
{
    return URLROOT . $target;
}

/**
 * Add a string to header.
 *
 * @access	public
 * @param       string data
 * @return	boolean
 */

function addHeaderData($data)
{
    addToNamespace('headers' , $data);
    return TRUE;
}

/**
 * Render header code.
 *
 * @access	public
 * @return	string
 */

function headerScripts()
{
    loadLogikitCSS('logikit.css.php?urlRoot=' . URLROOT);
    $flashMessage = getNamespaceValue('FlashMessage');
    if($flashMessage != NULL)
    {
        flashMessage();
    }
    $result = '';
    $headerDataArray = getNamespaceValues('headers');
    foreach($headerDataArray as $headerData)
    {
        $result .= "\n" . $headerData . "\n";
    }
    return $result;
}

/**
 * Add a string to body.
 *
 * @access	public
 * @param       string data
 * @return	string
 */
function addBodyData($data)
{
    addToNamespace('body' , $data);
    return TRUE;
}

/**
 * Render body code.
 *
 * @access	public
 * @return	string
 */

function bodyCode()
{
    $result = '';
    $bodyDataArray = getNamespaceValues('body');
    foreach($bodyDataArray as $bodyData)
    {
        $result .= "\n" . $bodyData;
    }

    return $result;
}

/**
 * Add a Javascript string to header.
 *
 * @access	public
 * @param       string data
 * @return	boolean
 */
function addScript($data)
{
    addHeaderData('<script type="text/javascript" language="javascript" charset="utf-8">' . $data . '</script>');
    return TRUE;
}

/**
 * Load a Javascript file.
 *
 * @access	public
 * @param       string scriptName
 * @return	boolean
 */

function loadScript($scriptName)
{
    addHeaderData('<script type="text/javascript" language="javascript" charset="utf-8" src="' .
                             URLROOT . 'javascript/' . $scriptName . '"></script>');
    return TRUE;
}

/**
 * Load a Javascript file from logikitPublic directory.
 *
 * @access	public
 * @param       string scriptName
 * @return	boolean
 */

function loadLogikitScript($scriptName)
{
    addHeaderData('<script type="text/javascript" language="javascript" charset="utf-8" src="' .
                             URLROOT . 'logikitPublic/javascript/' . $scriptName . '"></script>');
    return TRUE;
}

/**
 * Load JQuery.
 *
 * @access	public
 * @param       string  content
 * @return	boolean
 */

function loadJQuery()
{
    loadLogikitScript('jquery.js');
    return TRUE;
}

/**
 * Load Scripts from logikitPublic directory.
 *
 * @access	public
 * @param       array   extensionArray
 * @return	boolean
 */

function loadLogikitScripts($extensionArray)
{
    foreach($extensionArray as $extension)
    {
        loadLogikitScript($extension);
    }
    
    return TRUE;
}

/**
 * Load Scripts.
 *
 * @access	public
 * @param       array   extensionArray
 * @return	boolean
 */

function loadScripts($extensionArray)
{
    foreach($extensionArray as $extension)
    {
        loadScript($extension);
    }
    
    return TRUE;
}

/**
 * Load a CSS file.
 *
 * @access	public
 * @param       string   fileName
 * @return	boolean
 */

function loadCSS($fileName)
{
    addHeaderData('<style type="text/css">@import "' . URLROOT . 'css/' . $fileName . '";</style>');
    return TRUE;
}

/**
 * Load a CSS file from logikitPublic directory.
 *
 * @access	public
 * @param       string   fileName
 * @return	boolean
 */

function loadLogikitCSS($fileName)
{
    addHeaderData('<style type="text/css">@import "' . URLROOT . 'logikitPublic/css/' . $fileName . '";</style>');
    return TRUE;
}

/**
 * Display a "flash message"
 *
 * @access	public
 * @return	boolean
 */

function flashMessage()
{
    $scriptContent = NULL;
    
    if(isset($_SESSION['FlashMessage'][0]))
    {
        addHeaderData('<script type="text/javascript" language="javascript" charset="utf-8">$(document).ready(function(){
        setTimeout(function(){
        $(".flash").fadeOut("slow", function () {
        $(".flash").remove();
            }); }, 2000);
       });</script>');
        addBodyData('<div class="flash onTop">' .  $_SESSION['FlashMessage'][0] . '</div>');
       
        unset($_SESSION['FlashMessage'][0]);
    } 
   
    return TRUE;
}

/**
 * Format the return URL to be used in case an ajax form validation is successful.
 *
 * @access	public
 * @return	boolean
 */

function returnUrl($action)
{
    return URLROOT . getNamespaceValue('controller'). '/' . $action;
}

/* End of file view.php 
   Location: ./system/helper/view.php */