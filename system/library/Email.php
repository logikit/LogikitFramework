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
 * Email Sending Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------


class Email
{
    public $headers , $from , $to , $cc = NULL , $bcc = NULL , $subject , $body , $replyTo = NULL;
    private $boundary;
    private $hasAttachment = 0;

    /**
    * Constructor
    *
    * 
    *
    */
    
    public function __construct()
    {
        $rand = uniqid(rand()); 
        $this->boundary = 'multipartBoundary' . $rand; 
    }

    /**
    * Add a "from" line to the header
    *
    * @access	    public
    * @param        string  from
    * @return	    boolean
    */
    
    public function from($from)
    {
        if(is_array($from))
        {
            $sen = '';
            foreach($from as $sender)
            {
                $sen = $sender . ',';
            }
            $sen = substr($sen , 0 , -1);
        }
        else $sen = $from;
        
        $this->from = $sen;
    }

    /**
    * Add a "to" line to the header
    *
    * @access	    public
    * @param        string  to
    * @return	    boolean
    */
    
    public function to($to)
    {
        if(is_array($to))
        {
            $rec = '';
            foreach($to as $recipient)
            {
                $rec = $recipient . ',';
            }
            $rec = substr($rec , 0 , -1);
        }
        else $rec = $to;
        
        $this->to = $rec;
    }
    
    /**
    * Add a "cc" line to the header
    *
    * @access	    public
    * @param        string  cc
    * @return	    boolean
    */
    
    public function cc($cc)
    {
        if(is_array($cc))
        {
            $rec = '';
            foreach($cc as $recipient)
            {
                $rec = $recipient . ',';
            }
            $rec = substr($rec , 0 , -1);
        }
        else $rec = $cc;
        
        $this->cc = $rec;
    }
    
    /**
    * Add a "bcc" line to the header
    *
    * @access	    public
    * @param        string  cc
    * @return	    boolean
    */
    
    public function bcc($bcc)
    {
        if(is_array($bcc))
        {
            $rec = '';
            foreach($bcc as $recipient)
            {
                $rec = $recipient . ',';
            }
            $rec = substr($rec , 0 , -1);
        }
        else $rec = $bcc;
        
        $this->bcc = $rec;
    }
    
    /**
    * Alter "Reply-to" line of the header
    *
    * @access	    public
    * @param        string  replyTo
    * @return	    boolean
    */
    
    public function replyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }
    
    /**
    * Alter "Subject" line of the header
    *
    * @access	    public
    * @param        string  subject
    * @return	    boolean
    */
    
    public function subject($subject)
    {
        $this->subject = $subject;
    }
    
    /**
    * Create mail body
    *
    * @access	    public
    * @param        string  $body
    * @return	    boolean
    */
    
    public function message($body)
    {
        $this->body = $body;
    }
    
    /**
    * Add a header line
    *
    * @access	    public
    * @param        string  header
    * @return	    boolean
    */
    
    public function addHeader($header)
    {
        $this->headers .= $header . "\r\n";
        
        return TRUE;
    }

    /**
    * Attach a file
    *
    * @access	    public
    * @param        string  filePath
    * @return	    boolean
    */
    
    public function attach($filePath)
    {
        if($this->hasAttachment == 0) $this->addHeader("\nMIME-Version: 1.0\n" .
                                                       "Content-Type: multipart/mixed;\n" . " boundary=\"{" . $this->boundary . "}\"");        
        
        $file = fopen($filePath , "rb");
	$data = fread($file , filesize($filePath));
	fclose($file);
	$data = chunk_split(base64_encode($data));
	$this->body .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$filePath\"\n" . 
	"Content-Disposition: attachment;\n" . " filename=\"$filePath\"\n" . 
	"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	$this->body .= "--{" . $this->boundary . "}\n";

        $this->hasAttachment = 1;
        
        return TRUE;
    }
    
    /**
    * Add the necessary attachment string to the message body
    *
    * @access	    private
    * @return	    boolean
    */
    
    private function _addAttachmentMessage()
    {
        $this->body =  "--" . $this->boundary ."\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $this->body . "\n\n" . "--{" . $this->boundary . "}\n"; 
    
        return TRUE;
    }
    
    /**
    * Send email
    *
    * @access	    public
    * @return	    boolean
    */
    
    public function send()
    {
        $this->addHeader('From: ' . $this->from);
        ($this->replyTo == NULL) ? $this->addHeader('Reply-To: ' . $this->from) : $this->addHeader('Reply-To: ' . $this->replyTo);
        if($this->cc != NULL) $this->addHeader('Cc: ' . $this->cc);
        if($this->bcc != NULL) $this->addHeader('Bcc: ' . $this->cc);
        $this->addHeader('Return-Path: ' . $this->from);
        $this->addHeader('X-mailer: PHP');
        
        if($this->hasAttachment == 1) $this->_addAttachmentMessage();
        
        mail($this->to , $this->subject , $this->body , $this->headers);
        
        return TRUE;
    }


    
}