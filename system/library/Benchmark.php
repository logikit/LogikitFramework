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
 * Benchmark Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

class Benchmark
{
    /**
    * Constructor
    *
    * 
    *
    */
    
    public $benchmarks = array();
    
    public function __construct()
    {
        
    }
    
    /**
    * Add a mark
    *
    * @access	    public
    * @param        string  markName
    * @return	    boolean
    */
    
    public function add($markName)
    {
        $this->benchmarks[$markName] = microtime(1);
        return TRUE;
    }
    
    /**
    * Calculate time elapsed between two marks in microtime
    *
    * @access	    public
    * @param        string  firstMark
    * @param        string  lastMark
    * @return	    integer
    */
    
    public function elapsed($firstMark , $lastMark)
    {
        return ($this->benchmarks[$lastMark] - $this->benchmarks[$firstMark]);
    }
}

// END Benchmark class

/* End of file Benchmark.php 
   Location: ./system/library/Benchmark.php */