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
 * Logikit URI Helpers
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
 * Get the URI
 *
 * @access	public
 * @return	array
 */

function getUri()
{
    (isset($_SERVER['PATH_INFO'])) ? $pathInfo = substr($_SERVER['PATH_INFO'] , 1) : $pathInfo = substr($_SERVER['QUERY_STRING'] , 1);
    return explode('/' , $pathInfo);
}

function findController()
{
    $result = array();
    $testString = '';
    $uri = getUri();
    $segmentNum = sizeof($uri);
    for($n = 0; $n < $segmentNum; $n++)
    {
        $controllerTest = $testString . ucfirst(strtolower($uri[$n])) . '.php';
        if(is_file(APPLICATIONPATH . 'controller/' . $controllerTest))
        {
            $result['path'] = APPLICATIONPATH . 'controller/' . $controllerTest;
            $result['segment'] = $n;
            $result['controllerName'] = ucfirst(strtolower($uri[$n]));
            $result['classPath'] = str_replace('.php' , '', $controllerTest);
            return $result;
        }
        else
        {
            $testString .= $uri[$n] . '/';
        }
    }
    
    return FALSE;
}

/**
 * Check if the given string represents a controller
 *
 * @access	public
 * @param       string  controller
 * @return	boolean
 */

function isController($controller)
{
    if(is_file(APPLICATIONPATH . 'controller/' . $controller . '.php')) return TRUE;
    
    return FALSE;
}

/**
 * Check if the given string represents an action
 *
 * @access	public
 * @param       string  controller
 * @return	boolean
 */

function isAction($controller , $action)
{
        $methods = get_class_methods($controller);
        if(in_array($action , $methods)) return TRUE;
        
        return FALSE;
}

/**
 * Parse the URI and retrieve a parameter 
 *
 * @access	public
 * @param       string  paramName
 * @param       string default
 * @return	mixed
 */

function getParameter($paramName , $default = NULL)
{
    $uri = getUri();
    foreach($uri as $key => $value)
    {
        if($value == $paramName)
        {
            if(isset($uri[$key + 1]) && $uri[$key + 1] != NULL) return $uri[$key + 1]; else return $default;
        }
    }
    
    return $default;
}

/**
 * Redirect 
 *
 * @access	public
 * @param       string  path
 * @param       string default
 */

function redirect($path = '')
{
    header('Location:' . URLROOT . $path);
    exit;
}

/* End of file uri.php 
   Location: ./system/helper/uri.php */