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
 * Logikit File Helpers
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
* Check if the path is writable
*
* @access       public
* @param        string  path
* @return	integer
*/

function isWritable($path)
{

    if (substr($path , -1 ) == '/') return isWritable($path . uniqid(mt_rand()) . '.tmp');
    
    if (file_exists($path))
    {
        try {
                !$f = fopen($path  , 'r+');
            }
            catch (MyException $e)
            {
                return FALSE;
            }
        
        fclose($f);
        return TRUE;
    }
    
    if (!(@$f = fopen($path , 'w'))) return FALSE;
    
    fclose($f);
    @unlink($path);
    return TRUE;
}

?>