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
 * Logikit Ajax Helpers
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
* Generate ajax validation script
*
* @access       public
* @param        string  formId
* @return       boolean
*/

function ajaxValidate($formId)
{
    loadLogikitScript('jquery.form.js');
    addScript("$(document).ready(function()
                  { 
    var options = {
        success:   showValidationStatus,
        dataType:  'json' 
    }; 
 
    // bind form using 'ajaxForm' 
    $('#" . $formId . "').ajaxForm(options);
});


function showValidationStatus(responseText, statusText)
{ 
    for (var errorResponse in responseText)
    {
        var value = responseText[errorResponse];
         $('#'+ errorResponse+ 'Validation').empty();
        if(value != '1') $('#'+ errorResponse+ 'Validation').append(value);
    }
    if(responseText.validationOverAll == true) top.location = responseText.returnUrl;
} ");

    return TRUE;
}

function loadPaginationScripts($start , $limit , $total , $orderBy = 'id' , $order = 'ASC')
{
    addScript("$(document).ready(function()
                  { 
    start = " . $start . ";
    limit = " . $limit . ";
    orderBy = '" . $orderBy . "';
    order = '" . $order . "';
    total = " . $total . ";
    pageOld = 0;
    firstDisplay = 0;
    getPaginatedData(start , limit);
    
    });
    
    function getPaginatedData()
    {
             $.ajax({
       type: \"POST\",
       url: \"" .URLROOT . getController() . "/paginator\",
       data: \"start=\" + start + \"&limit=\" + limit + '&orderBy=' + orderBy + '&order=' + order,
       success: function(msg){
            $('#paginatedData').empty();
            $('#paginatedData').append(msg);
            
            var pageNum = parseInt(start / limit);
            
            $('#paginatedPage' + pageOld).toggleClass('selectedPage');
            if(firstDisplay != 0) $('#paginatedPage' + pageNum).toggleClass('selectedPage');
            pageOld = pageNum;
            
            firstDisplay = 1;
            
            if(start <= 0) $('#paginatePrevious').hide(); else $('#paginatePrevious').show();
            
            if((parseInt(start) + parseInt(limit)) >= total) $('#paginateNext').hide(); else $('#paginateNext').show();
       }
     });
    }
    
    function getNext()
    {
            start = start + limit;
            getPaginatedData(start , limit);
    }
    
    function getPrevious()
    {
            start = start - limit;
            getPaginatedData(start , limit);
    }
    
    function getPage(startNum)
    {
        start = startNum;
        getPaginatedData(start , limit);
    }
    
    function changeOrder(field)
    {
        start = 0;  
        orderBy = field;
        if(order == 'ASC') order = 'DESC'; else order = 'ASC';
        getPaginatedData();
    }");
}

function generateAjaxPaginator($limit , $recordCount)
{
    $content = '<a id="paginatePrevious" href="javascript:getPrevious();">previous</a> ';
    
    $pageNum = $recordCount / $limit;
    for($n = 0; $n < $pageNum; $n++)
    {
        $page = $n * $limit;
        $pageDisplayed = $n + 1;
        $content .= '<span id="paginatedPage' . $n . '"><a href="javascript:getPage(\'' . $page . '\');">' . $pageDisplayed . '</a></span> ';
    }
    
    $content .= '<a id="paginateNext" href="javascript:getNext();">next</a>';
    
    return $content;
}

/* End of file ajax.php 
   Location: ./system/helper/ajax.php */