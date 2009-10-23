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

class EditForm extends LogikitForm
{
    public function __construct()
    {
        
        $this->addItem(array(
                             'name' => 'id' ,
                             'type' => 'hidden' ,
                             'value' => NULL ,
                             'validation' => array() ,
                             'properties' => ''));
        
        
	$this->addItem(array(
                                     'name' => 'title' ,
                                     'type' => 'textBox' ,
                                     'value' => NULL ,
                                     'validation' => array('notNull') ,
                                     'properties' => ''));

	$this->addItem(array(
                                     'name' => 'entry' ,
                                     'type' => 'textArea' ,
                                     'value' => NULL ,
                                     'validation' => array('notNull') ,
                                     'properties' => ''));

	$this->addItem(array(
                                     'name' => 'date' ,
                                     'type' => 'datePicker' ,
                                     'value' => NULL ,
                                     'validation' => array('notNull') ,
                                     'properties' => ''));

        $this->addItem(array(
                             'name' => 'submit1' ,
                             'type' => 'submit' ,
                             'value' => 'Go' ,
                             'validation' => NULL ,
                             'properties' => 'class="submit1"'));
    }
}

// END Testform class

/* End of file Testform.php 
   Location: ./system/application/form/ControlPanel/Testform.php */