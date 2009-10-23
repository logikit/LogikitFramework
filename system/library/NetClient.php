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
 * NetClient Class
 *
 * Requires php-cURL extension installed.
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

class NetClient
{
	private $_curl;
	private $_cookieFile = 'cookie.txt';
	private $_userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9) Gecko/2008061015 Firefox/3.0';
	private $_httpHeader = array("Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" , "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" , "Accept-Language: tr,en-us;q=0.7,en;q=0.3", "Keep-Alive: 300");
	private $_header = false;
	private $_timeout = 60;

    /**
    * Constructor
    *
    * Initialize cUrl
    *
    */

	public function __construct()
	{
		$this->setCookie();
		$this->_curl = curl_init();
		curl_setopt($this->_curl , CURLOPT_COOKIEJAR , $this->_cookieFile);
		curl_setopt($this->_curl , CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->_curl , CURLOPT_VERBOSE , TRUE);
		curl_setopt($this->_curl , CURLOPT_FOLLOWLOCATION , TRUE);
		curl_setopt($this->_curl , CURLOPT_HTTPHEADER , $this->_httpHeader);
		curl_setopt($this->_curl , CURLOPT_USERAGENT , $this->_userAgent);
		curl_setopt($this->_curl , CURLOPT_HEADER , $this->_header);
		curl_setopt($this->_curl , CURLOPT_COOKIEFILE , $this->_cookieFile);
		curl_setopt($this->_curl , CURLOPT_TIMEOUT , $this->_timeout);
		curl_setopt($this->_curl , CURLE_OPERATION_TIMEOUTED , $this->_timeout);

	}
	
	/**
	* Fetch the content of a URL
	*
	* @access	public
	* @param        string  url
	* @param        array  	post
	* @return	boolean
	*/
    
	public function fetchUrl($url , $post = FALSE)
	{
		if ($post != FALSE)
		{
			curl_setopt($this->_curl , CURLOPT_POST , TRUE);
			curl_setopt($this->_curl , CURLOPT_POSTFIELDS , $post);
		}
		curl_setopt($this->_curl , CURLOPT_URL , $url);
		return curl_exec($this->_curl);
	}
	
	/**
	* Fetch the content of a URL
	*
	* @access	public
	* @param        string  url
	* @param        string  localPath
	* @return	mixed
	*/
	
	public function download($url , $localPath)
	{
		$file = fopen($localPath , "w");
		curl_setopt($this->_curl , CURLOPT_URL , $url);
		curl_setopt($this->_curl , CURLOPT_FILE , $file);
		return curl_exec($this->_curl);
	}
	
	/**
	* Set Referer
	*
	* @access	public
	* @param        string  referer
	* @return	boolean
	*/
	
	public function setReferer($referer)
	{
		curl_setopt($this->_curl , CURLOPT_REFERER , $referer);
		
		return TRUE;
	}
	
	/**
	* Get CURL info
	*
	* @access	public
	* @return	array
	*/
	
	public function getInfo()
	{
		return @curl_getinfo($this->_curl);
	}

	/**
	* Set Cookie
	*
	* @access	public
	* @return	boolean
	*/
	
	public function setCookie()
	{
		$root = $_SERVER ['DOCUMENT_ROOT'];
		$txt = strrev($_SERVER ['PHP_SELF']);
		$path = strrev(substr($txt , strpos($txt , '/') , strlen($txt) - strpos($txt , '/')));
		$this->_cookieFile = $root . $path . $this->_cookieFile;
		@touch ($this->_cookieFile);
		@chmod ($this->_cookieFile , 0777);
		
		return TRUE;
	}

	/**
	* Set User agent
	*
	* @access	public
	* @param	string	userAgent
	* @return	boolean
	*/
	
	public function setUserAgent($userAgent)
	{
		$this->_userAgent = $userAgent;
		
		return TRUE;
	}
	
	/**
	* Set Cookie File
	*
	* @access	public
	* @param	string	cookieFile
	* @return	boolean
	*/
	
	public function setCookieFile($cookieFile)
	{
		$this->_cookieFile = $cookieFile;
		
		return TRUE;
	}
	
	/**
	* Set Timeout
	*
	* @access	public
	* @param	integer	secs
	* @return	boolean
	*/
	
	public function setTimeout($secs)
	{
		$this->_timeout = $secs;
		
		return TRUE;
	}
	
	/**
	* Set Session ID
	*
	* @access	public
	* @param	string	sid
	* @return	string
	*/
	
	public function getSessionId($sid = "PHPSESSID")
	{
		$cookie = file_get_contents($this->_cookieFile);
		if(strstr($cookie, $sid ))
		{
			$sessionArray = explode("\t" , strstr($cookie , $sid));
			$session = trim($sessionArray[1]);
	
			return $session;
		}
		return FALSE;
	}
	
	/**
	* Close cURL connection
	*
	* @access	public
	* @return	boolean
	*/
	
	private function _closeConnection()
	{
		curl_close($this->_curl);
		
		return TRUE;
	}
}

// END NetClient class

/* End of file NetClient.php 
   Location: ./system/library/NetClient.php */