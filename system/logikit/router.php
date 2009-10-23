<?php

$uri = getUri();

$currentController = ucfirst(strtolower($uri[0]));
//is $uri[0] a controller?
if(isController($currentController))
{
    require_once(APPLICATIONPATH . 'controller/' . $currentController. '.php');
    //is $uri[1] an action?
    if(isset($uri[1]) && isAction($currentController , $uri[1]))
    {
        $currentAction = $uri[1];
    }
    elseif(!isset($uri[1]) || $uri[1] == '')
    {
        $currentAction = $defaultAction;
    }
    else
    {
        $currentController = '404';
        $currentAction = 'index';
    }

}
elseif(!isset($uri[0]) || $uri[0] == '')
{
    $currentController = $defaultController;
    $currentAction = $defaultAction;
}
else
{
    $currentController = '404';
    $currentAction = 'index';
}
    if($currentController != '404') require_once(APPLICATIONPATH . 'controller/' . $currentController. '.php');
    else
    {
        $_SESSION['urlRoot'] = URLROOT;
        require_once(SYSTEMPATH . 'errorPages/404.php');
        exit;
    }
    $$currentController = new $currentController();
    
    if(is_array($autoload)) $$currentController->autoload($autoload);

    if(!isAction($currentController , $currentAction)) die('Default action "' . $defaultAction . '" not defined in controller "' . $currentController . '".');
    
    $_SESSION['action'][0] = $currentAction;
/* End of file router.php 
   Location: ./system/logikit/router.php */