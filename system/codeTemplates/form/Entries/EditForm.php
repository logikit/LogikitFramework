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
        
        __ITEMS__
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