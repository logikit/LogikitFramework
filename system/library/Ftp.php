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
 * FTP Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------


class Ftp
{
    private $_user , $_password , $_host , $_port = 21 , $_connected = FALSE , $_connection , $_warning = FALSE;

    /**
    * Constructor
    *
    * 
    *
    */
    
    public function __construct()
    {

    }

    /**
    * Alter connection settings
    *
    * @access	    public
    * @param        array  array
    * @return	    boolean
    */
    
    public function settings($array)
    {
        if(isset($array['user'])) $this->_user = $array['user'];
        if(isset($array['password'])) $this->_password = $array['password'];
        if(isset($array['host'])) $this->_password = $array['host'];
        if(isset($array['port'])) $this->_password = $array['port'];
        
        return TRUE;
    }
    
    /**
    * Alter warning settings
    *
    * @access	    public
    * @param        boolean  flag
    * @return	    boolean
    */
    
    public function warnings($flag)
    {
        
        $this->_warning = $flag;
                
        return TRUE;
    }
    
    /**
    * Connect to a remote server
    *
    * @access	    public
    * @param        string  host
    * @param        string  userName
    * @param        string  password
    * @param        string  port
    * @return	    boolean
    */
    
    public function connect($host = NULL , $userName = NULL , $password = NULL , $port = NULL)
    {
        if($host == NULL) $host = $this->_host;
        if($userName == NULL) $userName = $this->_user;
        if($password == NULL) $password = $this->_password;
        if($port == NULL) $port = $this->_port;
        
        if(!$this->_connection = @ftp_connect($host , $port))
        {
            triggerWarning('Could not connect to the server');
            return FALSE;
        }
        if (!@ftp_login($this->_connection , $userName , $password))
        {
            triggerWarning('Could not login to the server');
            return FALSE;           
        }
        
        $this->_connected = TRUE;
        return TRUE;
    }
    
    /**
    * Close a connection
    *
    * @access	    public
    * @return	    boolean
    */
    
    public function close()
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;           
        }
        
        ftp_close($this->_connection);
        
        $this->_connected = FALSE;
        return TRUE;
    }
    
    /**
    * Change the remote directory
    *
    * @access	    public
    * @param        string  path
    * @return	    boolean
    */
    
    public function changeDir($path)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;           
        }

        ftp_chdir($this->_connection , $path);
        return TRUE;
    }
    
    /**
    * Get the file content of a remote directory
    *
    * @access	    public
    * @param        string  path
    * @return	    array
    */
    
    public function listFiles($path)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;           
        }

        $files = ftp_nlist($this->_connection , $path);
        return $files;
    }
    
    /**
    * Upload a file
    *
    * @access	    public
    * @param        string  localPath
    * @param        string  remotePath
    * @param        string  mode
    * @param        string  permission
    * @return	    boolean
    */
    
    public function upload($localPath , $remotePath , $type = 'auto' , $permission = NULL)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if(!is_file($localPath))
        {
            triggerWarning('Local file ' . $localPath . ' could not be found.');
            return FALSE;  
        }
        
        if($type == 'auto')
        {
            $extension = $this->_getFileExtension($localPath);
            $type = $this->_setType($extension);
        }
        else $mode = $type;
        
        ($type == 'ascii') ? $mode = 'FTP_ASCII' : $mode = 'FTP_BINARY';
    
	$result = @ftp_put($this->_connection , $remotePath , $localPath , $mode);
        
        if ($result === FALSE)
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Local file ' . $localPath . ' could not be uploaded.');
            }
            return FALSE;  
        }

        if (!is_null($permission))
        {
            $this->changeMod($remotePath , intval($permission));
        }
        
        return TRUE;
    }
    
    /**
    * Download a file
    *
    * @access	    public
    * @param        string  localPath
    * @param        string  remotePath
    * @param        string  mode
    * @param        string  permission
    * @return	    boolean
    */
    
    public function download($localPath , $remotePath , $type = 'auto' , $permission = NULL)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if($type == 'auto')
        {
            $extension = $this->_getFileExtension($localPath);
            $type = $this->_setType($extension);
        }
        else $mode = $type;
        
        ($type == 'ascii') ? $mode = 'FTP_ASCII' : $mode = 'FTP_BINARY';
    
	$result = @ftp_get($this->_connection , $localPath , $remotePath , $mode);
        
        if ($result === FALSE)
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Remote file ' . $remotePath . ' could not be downloaded.');
            }
            return FALSE;  
        }

        if (!is_null($permission))
        {
            chmod($localPath , intval($permission));
        }
        
        return TRUE;
    }

    /**
    * Change file permission
    *
    * @access	    public
    * @param        string  path
    * @param        string  permissions
    * @return	    boolean
    */
    
    public function changeMod($path , $permissions)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }

        if(@ftp_chmod($this->_connection , $path , $permissions)) return TRUE;
        else
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Permissions for remote file ' . $path . ' could not be changed.');
            }
            return FALSE;  
        }
    }

    /**
    * Create a remote directory
    *
    * @access	    public
    * @param        string  path
    * @return	    boolean
    */
    
    public function makeDir($path)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if(@ftp_mkdir($this->_connection , $path)) return TRUE;
        else
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Remote directory ' . $path . 'could not be created.');
            }
            return FALSE;  
        }
    }
    
    /**
    * Move a remote file
    *
    * @access	    public
    * @param        string  olFile
    * @param        string  newFile
    * @return	    boolean
    */
    
    public function move($path)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if(@ftp_rename($this->_connection , $oldFile , $newFile)) return TRUE;
        else
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Remote file ' . $path . 'could not be moved.');
            }
            return FALSE;  
        }
    }
    
    /**
    * Upload a local directory content to the remote host
    *
    * @access	    public
    * @param        string  localPath
    * @param        string  remotePath
    * @return	    boolean
    */
    
    public function mirrorUp($localPath , $remotePath)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if (@$handle = opendir($localPath))
        {
            while (false !== ($file = readdir($handle)))
            {
                if($file == '.' || $file == '..') continue;
                
                if(chdir($localPath . '/' . $file))
                {
                    if(!@ftp_chdir($remotePath . '/' . $file))
                    {
                        $this->makeDir($remotePath . '/' . $file);
                    }
                    $this->mirrorUp($localPath . '/' . $file , $remotePath . '/' . $file);
                }
                else
                {
                    $this->upload($localPath . '/' . $file , $remotePath . '/' . $file);
                }
            }

            closedir($handle);
            return TRUE;
        }
        else
        {
            triggerWarning('Could not open local path ' . $localPath);
            return FALSE;  
        }
    }
    
    /**
    * Download a remote directory content to the local host
    *
    * @access	    public
    * @param        string  localPath
    * @param        string  remotePath
    * @return	    boolean
    */
    
    public function mirrorDown($localPath , $remotePath)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if ($this->changeDir($remotePath))
        {
            $remoteContents = $this->listFiles($remotePath);
            foreach($remoteContents as $remoteFile)
            {
                if($remoteFile == '.' || $remoteFile == '..') continue;
                
                if(@$this->changeDir($remotepath . '/' . $remoteFile))
                {
                    if(!@chdir($localPath . '/' . $localFile))
                    {
                        if(!@mkdir($localPath . '/' . $localFile))
                        {
                            triggerWarning('Could not create local directory' . $localPath . '/' . $localFile);
                        }
                    }
                    $this->mirrorDown($remotePath . '/' . $remoteFile);
                }
                else
                {
                    $this->download($localPath . '/' . $remoteFile , $remotePath . '/' . $remoteFile);
                }
            }
        }
        else
        {
            triggerWarning('Could not open remote path ' . $path);
            return FALSE;  
        }
    }

    /**
    * Delete a remote file
    *
    * @access	public
    * @param	string  fileName
    * @return	string
    */
    
    public function deleteFile($fileName)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if(@ftp_delete($this->_connection , $fileName)) return TRUE;
        else
        {
            if($this->_warning == TRUE)
            {
                triggerWarning('Remote file ' . $path . 'could not be deleted.');
            }
            return FALSE;  
        }        
    }
    
    /**
    * Delete a remote directory recursively
    *
    * @access	public
    * @param	string  remotePath
    * @return	string
    */
    
    public function deleteDirectory($remotePath)
    {
        if(!$this->_connected)
        {
            triggerWarning('There is no active connection');
            return FALSE;  
        }
        
        if ($this->changeDir($remotePath))
        {
            $remoteContents = $this->listFiles($remotePath);
            
            foreach($remoteContents as $remoteFile)
            {
                if($remoteFile == '.' || $remoteFile == '..') continue;
                
                if(@$this->changeDir($remotePath . '/' . $remoteFile))
                {
                    $this->deleteDirectory($remotePath . '/' . $remoteFile);
                }
                else
                {
                    $this->deleteFile($remotePath . '/' . $remoteFile);
                }
            }
        }
        else
        {
            triggerWarning('Could not open remote path ' . $path);
            return FALSE;  
        }
        
      
    }
   
    /**
    * Get the file extension
    *
    * @access	private
    * @param	string  fileName
    * @return	string
    */
    
    private function _getFileExtension($fileName)
    {
        if (!strstr($fileName , '.'))
        {
                return 'txt';
        }

        $dotsArray = explode('.' , $fileName);
        return end($dotsArray);
    }

    /**
    * Set the FTP port
    *
    * @access	private
    * @param	integer  port
    * @return	boolean
    */
    
    private function setPort($port)
    {
        $this->_port = $port;
        
	return TRUE;
    }
   
    /**
    * Set the transfer type
    *
    * @access	private
    * @param	string  extension
    * @return	string
    */
    
    private function _setType($extension)
    {
        $textTypes = array();

        $textTypes[] = 'txt';
        $textTypes[] = 'php';
        $textTypes[] = 'phps';
        $textTypes[] = 'php3';
        $textTypes[] = 'php4';
        $textTypes[] = 'js';
        $textTypes[] = 'htm';
        $textTypes[] = 'html';
        $textTypes[] = 'phtml';
        $textTypes[] = 'shtml';
        $textTypes[] = 'log';
        $textTypes[] = 'xml';
        
	return (in_array($extension , $textTypes)) ? 'ascii' : 'binary';
    }
    
}