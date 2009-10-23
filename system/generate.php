#!/usr/bin/php
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
 * CRUD generator
 *
 * @package		Logikit Framework
 * @subpackage	        Generator
 * @category	        Generator
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

$silent = 0;
$generationDir = './generated';
$regenerate = 0;
$exludeTables = array();

foreach($argv as $key => $argument)
{
    if($argument == '--regenerate') $regenerate = 1;
    
    if($argument == '--silent') $silent = 1;
    
    if($argument == '--exclude-tables')
    {
        $excludeTables = explode (':' , $argv[$key + 1]);
    }
    
    if($argument == '--generation-dir')
    {
        $generationDir = $argv[$key + 1];
    }    
}

$dirname = dirname(__FILE__);
$currentDirArray = explode('/' , $dirname);
$systemDir = end($currentDirArray);

define('FILEROOT' , str_replace($systemDir , '' , dirname(__FILE__)));
define('APPLICATIONPATH' , FILEROOT . 'application/');
require APPLICATIONPATH . 'config/config.php';
require './model/LogikitModel.php';

if(!is_dir($generationDir . '/controller')) mkdir($generationDir . '/controller' , 0777);
if(!is_dir($generationDir . '/model')) mkdir($generationDir . '/model' , 0777);
if(!is_dir($generationDir . '/view')) mkdir($generationDir . '/view' , 0777);
if(!is_dir($generationDir . '/form')) mkdir($generationDir . '/form' , 0777);
if(!is_dir($generationDir . '/validator')) mkdir($generationDir . '/validator' , 0777);

class InstallModel extends LogikitModel
{
    public function __construct()
    {
        parent::__construct();
    }
}

function canWrite($path , $regenerationValue)
{
    if(!is_file($path)) return true;
    
    if($regenerationValue == 1) return true;
    
    return false;
}

$InstallModel = new InstallModel();
$tables = $InstallModel->tables();
foreach($tables as $row)
{
    //generate controller file

    if(!isset($excludeTables[0]) || !in_array($row , $excludeTables))
    {
        $className = ucfirst($row);
        
        $columns = $InstallModel->columns($row);
        $itemData = NULL;
        $rowItemsData = NULL;
        $actionItemsData = NULL;
        
        $controllerItemTemplate = "            <div class=" . '\"' . "dungeon tableHeader" . '\"' . ">
                        <a href=" . '\"' . "javascript:changeOrder('__ITEM__');" . '\"' . ">__ITEM_CAPS__</a>
            </div>\n";
        
        $rowItemsTemplate = "\n                <div class=" .'\"' . "dungeon" . '\"' . ">
                      \" . $" . "row['__ROWITEM__'] . \"
                </div>";
                
        $actionItemsTemplate = "siteLink(getController() . '/display/id/' . " . '$row' . "['id'] , 'display') . \" | \" .
            siteLink(getController() . '/edit/id/' . " . '$row' . "['id'] , 'edit') . \" | \" .
            siteLink(getController() . '/delete/id/' . " . '$row' . "['id'] , 'delete')";
        
        foreach($columns as $column)
        {
            $actionItemsData = NULL;
            if($column['Field'] != 'id')
            {
                $data = str_replace('__ITEM__' , $column['Field'] , $controllerItemTemplate);
                $data = str_replace('__ITEM_CAPS__' , ucfirst($column['Field']) , $data);
                $itemData .= $data;
                
                $rowItemsData .= str_replace('__ROWITEM__' , $column['Field'] , $rowItemsTemplate);
                
                $actionItemsData .= str_replace('__ROWITEM__' , $column['Field'] , $actionItemsTemplate);
            }
        
        }
        
        $controllerFile = file_get_contents('./codeTemplates/controller/Entries.php');
        $generatedController = str_replace('__CONTROLLER__' , $className , $controllerFile);
        $generatedController = str_replace('__ITEMS__' , $itemData , $generatedController);
        $generatedController = str_replace('__ROW_ITEMS__' , $rowItemsData , $generatedController);
        $generatedController = str_replace('__ACTION_ITEMS__' , $actionItemsData , $generatedController);
        
        if(canWrite($generationDir . '/controller/' . $className . '.php' , $regenerate))
        {
            file_put_contents($generationDir . '/controller/' . $className . '.php' , $generatedController);
        }
        
        //generate form file
        
        $formFile = file_get_contents('./codeTemplates/form/Entries/EditForm.php');
        
        $itemData = NULL;
        
        foreach($columns as $column)
        {
            switch($column['Type'])
            {
                case "longtext":
                case "mediumtext":
                    $type = 'textArea';    
                break;
            
                case "date":
                    $type = 'datePicker';    
                break;
            
                default:
                    $type = 'textBox';
                break;
            }
            if($column['Field'] != 'id') $itemData .= "\n\t$" . "this->addItem(array(
                                     'name' => '". $column['Field'] . "' ,
                                     'type' => '$type' ,
                                     'value' => NULL ,
                                     'validation' => array('notNull') ,
                                     'properties' => ''));\n";
        
        }
        
        $generatedForm = str_replace('__ITEMS__' , $itemData , $formFile);
        if(!is_dir($generationDir . '/form/' . $className)) mkdir($generationDir . '/form/' . $className);
        if(canWrite($generationDir . '/form/' . $className . '/EditForm.php' , $regenerate))
        {
            file_put_contents($generationDir . '/form/' . $className . '/EditForm.php' , $generatedForm);
        }
        //generate validator file
        
        $validatorFile = file_get_contents('./codeTemplates/validator/Entries/EditFormValidator.php');
        $generatedValidator = str_replace('__CONTROLLER__' , $className , $validatorFile);
        if(!is_dir($generationDir . '/validator/' . $className)) mkdir($generationDir . '/validator/' . $className);
        
        if(canWrite($generationDir . '/validator/' . $className . '/EditFormValidator.php' , $regenerate))
        {
            file_put_contents($generationDir . '/validator/' . $className . '/EditFormValidator.php' , $generatedValidator);
        }
        // generate model file
        
        $modelFile = file_get_contents('./codeTemplates/model/EntriesModel.php');
        $generatedModel = str_replace('__CONTROLLER__' , $className , $modelFile);

        if(canWrite($generationDir . '/model/' . $className . 'Model.php' , $regenerate))
        {
            file_put_contents($generationDir . '/model/' . $className . 'Model.php' , $generatedModel);
        }
        
        // generate view files
        if(!is_dir($generationDir . '/view/' . $className)) mkdir($generationDir . '/view/' . $className);
        
        $indexFile = file_get_contents('./codeTemplates/view/Entries/index.php');
        $editFile = file_get_contents('./codeTemplates/view/Entries/edit.php');
        $displayFile = file_get_contents('./codeTemplates/view/Entries/display.php');
        
        $indexTitleTemplate = "        <div class=\"dungeon tableHeader\">
                    __FIELD__
                </div>\n";
        
        $indexItemTemplate = "        <div class=\"dungeon\">
                    <" . "?php echo $" . "record['__FIELD__']; ?" . ">
                </div>\n";
        
        $editItemTemplate = "    <div class=\"row\">
                <div class=\"dungeon tableHeader\">
                    __FIELD_CAPS__:
                </div>
                <div class=\"dungeon\">
                    <?" . "php echo $" . "formItems['__FIELD__'];?" . ">
                </div>
                <div class=\"dungeon validationError\" id=\"__FIELD__Validation\">
                
                 </div>    
            </div>\n";
            
        $displayItemTemplate = "    <div class=\"row\">
                <div class=\"dungeon tableHeader\">
                    __FIELD_CAPS__:
                </div>
                <div class=\"dungeon\">
                    <" . "?php echo $" . "record['__FIELD__']; ?" . ">
                </div>
                <div class=\"dungeon validationError\" id=\"__FIELD__Validation\">
                    
                </div>
            </div>\n";
        
        $headings = NULL;
        $items = NULL;
        $editItems = NULL;
        $displayItems = NULL;
        
        foreach($columns as $column)
        {
            if($column['Field'] != 'id')
            {
                $headings .= str_replace('__FIELD__' , ucfirst($column['Field']) , $indexTitleTemplate);
                $items .= str_replace('__FIELD__' , $column['Field'] , $indexItemTemplate);
                
                $editItem = str_replace('__FIELD_CAPS__' , ucfirst($column['Field']) , $editItemTemplate);
                $editItem = str_replace('__FIELD__' , $column['Field'] , $editItem);
                
                $editItems .= $editItem;
                
                $displayItem = str_replace('__FIELD_CAPS__' , ucfirst($column['Field']) , $displayItemTemplate);
                $displayItem = str_replace('__FIELD__' , $column['Field'] , $displayItem);
                
                $displayItems .= $displayItem;
            }
        }
        
        $generatedIndex = str_replace('__HEADINGS__' , $headings , $indexFile);
        $generatedIndex = str_replace('__CONTROLLER__' , $className , $generatedIndex);
        $generatedIndex = str_replace('__ITEMS__' , $items , $generatedIndex);
        
        $generatedEdit = str_replace('__ITEMS__' , $editItems , $editFile);
        
        $generatedDisplay = str_replace('__ITEMS__' , $displayItems , $displayFile);

        if(canWrite($generationDir . '/view/' . $className . '/index.php' , $regenerate))
        {      
            file_put_contents($generationDir . '/view/' . $className . '/index.php' , $generatedIndex);
        }

        if(canWrite($generationDir . '/view/' . $className . '/edit.php' , $regenerate))
        {          
            file_put_contents($generationDir . '/view/' . $className . '/edit.php' , $generatedEdit);
        }

        if(canWrite($generationDir . '/view/' . $className . '/display.php' , $regenerate))
        {         
            file_put_contents($generationDir . '/view/' . $className . '/display.php' , $generatedDisplay);
        }
    }  
}
/* End of file generate.php 
   Location: ./system/generate.php */