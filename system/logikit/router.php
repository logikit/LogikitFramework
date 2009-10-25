<?php

$uri = getUri();

$currentControllerData = findController();
if(!isset($currentControllerData) || $currentControllerData == FALSE)
{
    $currentController = '404';
    $currentAction = 'index';
}
else
{
    require_once($currentControllerData['path']);
    $currentController = $currentControllerData['controllerName'];
    $actionCandidateSegment = $currentControllerData['segment'] + 1;
    
    //is $uri[1] an action?
    if(isset($uri[$actionCandidateSegment]) && isAction($currentController , $uri[$actionCandidateSegment]))
    {
        $currentAction = $uri[$actionCandidateSegment];
    }
    else
    {
        $currentAction = $defaultAction;
    }
}

    if($currentController == '404')
    {
        $_SESSION['urlRoot'] = URLROOT;
        require_once(SYSTEMPATH . 'errorPages/404.php');
        exit;
    }
    
    //the controller may be in a sub directory so:
    
    $controllerInit = basename($currentController);
    
    $$currentController = new $controllerInit();
    
    if(is_array($autoload)) $$currentController->autoload($autoload);

    if(!isAction($currentController , $currentAction)) die('Default action "' . $defaultAction . '" not defined in controller "' . $currentController . '".');
    
    $_SESSION['action'][0] = $currentAction;
    
/* End of file router.php 
   Location: ./system/logikit/router.php */