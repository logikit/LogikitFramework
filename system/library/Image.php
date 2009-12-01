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
 * Image Manipulation Class
 *
 * @package		Logikit Framework
 * @subpackage	        Library
 * @category	        Library
 * @author		Can Ince
 */

// ------------------------------------------------------------------------

class Image
{
    
    protected $_image , $_imageData , $_thumb, $_watermarkImage;
    
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
    * Load an image
    *
    * @access	    public
    * @param        string  imagePath
    * @return	    boolean
    */
    
    public function loadImage($imagePath)
    {
        
        $this->_imageData = getimagesize($imagePath);
        switch($this->_imageData['mime'])
        {
            case 'image/gif':
                $this->_image =  imagecreatefromgif($imagePath);
                break;
                
            case 'image/jpeg':
                $this->_image =  imagecreatefromjpeg($imagePath);
                break;
                
            case 'image/png':
                $this->_image =  imagecreatefrompng($imagePath);
                break;
                
            default:
                return FALSE;
        }
        return TRUE;
    }
    
    /**
    * Set image
    *
    * @access	    public
    * @param        resource  $image
    * @return	    boolean
    */
    
    public function setImage($image)
    {
        $this->_image = $image;
    }
    
    /**
    * Set watermark image
    *
    * @access	    public
    * @param        resource  $image
    * @return	    boolean
    */
    
    public function setWatermarkImage($image)
    {
        $this->_watermarkImage = $image;
    }
    
    public function getImageData()
    {
        return $this->_imageData;
    }

    /**
    * Resize an image
    *
    * @access	    public
    * @param        integer  width
    * @param        integer  height
    * @return	    boolean
    */
   
    public function resize($width = NULL , $height = NULL)
    {
        if(!isset($this->_imageData) || !is_array($this->_imageData)) triggerError('Image data not set. Probably could not load the image properly.');
        $imageWidth = $this->_imageData[0];
        $imageHeight = $this->_imageData[1];
        if($height == NULL)
	{
	    $height = ($width * $imageHeight) / $imageWidth;
	}
        
        if($width == NULL)
	{
	    $width = ($height * $imageWidth) / $imageHeight;
	}
        $this->_thumb = imagecreatetruecolor($width, $height);
        echo "w:$width h:$height<br/>";
        imagecopyresized($this->_thumb , $this->_image , 0 , 0 , 0 , 0 , $width , $height , $imageWidth , $imageHeight);
    }
    
    /**
    * Crop an image
    *
    * @access	    public
    * @param        integer  xAxis
    * @param        integer  yAxis
    * @return	    boolean
    */
   
    public function crop($xAxis = NULL , $yAxis = NULL)
    {
        if(!isset($this->_imageData) || !is_array($this->_imageData)) triggerError('Image data not set. Probably could not load the image properly.');
        $imageWidth = $this->_imageData[0];
        $imageHeight = $this->_imageData[1];
        if($xAxis == NULL)
	{
	    $xAxis = $yAxis;
	}
        
        if($yAxis == NULL)
	{
	    $yAxis = $xAxis;
	}
        $thumbWidth = $imageWidth - $yAxis;
        $thumbHeight = $imageHeight - $yAxis;
        $this->_thumb = imagecreatetruecolor($thumbWidth , $thumbHeight);

        imagecopyresized($this->_thumb , $this->_image , 0 , 0 , $xAxis , $yAxis , $thumbWidth , $thumbHeight , $thumbWidth , $thumbHeight);

        return TRUE;
    }
    
    /**
    * Rotate an image
    *
    * @access	    public
    * @param        integer  angle
    * @return	    boolean
    */
    
    public function rotate($angle)
    {
        $imageWidth = $this->_imageData[0];
        $imageHeight = $this->_imageData[1];
        switch($angle)
        {
            case 90:
            case 270:
                $this->_thumb = @imagecreatetruecolor($imageHeight , $imageWidth);
                break;
          
            case 180:
                $this->_thumb = @imagecreatetruecolor($imageWidth , $imageHeight);
                break;
          
            case 0:
            case 360:
                return $this->_image;
                break;
            
            default:
            return FALSE;
        }
    
        for($i = 0; $i < $imageWidth; $i++)
        {
            for($p = 0; $p < $imageHeight; $p++)
            {
                $pixel = imagecolorat($this->_image , $i , $p);
                switch($angle)
                {
                    case 90:
                        if(!@imagesetpixel($this->_thumb , ($imageHeight - 1) - $p , $i , $pixel)) return FALSE;
                        break;
                    
                    case 180:
                        if(!@imagesetpixel($this->_thumb , $i , ($imageHeight - 1) - $p , $pixel)) return FALSE;
                        break;
                    
                    case 270:
                        if(!@imagesetpixel($this->_thumb , $p , $imageWidth - $i , $pixel)) return FALSE;
                        break;
                }
            }
        }
      
        return TRUE;
    }
    
    /**
    * Watermark
    *
    * @access	    public
    * @return	    boolean
    */
    
    public function watermark()
    {
        $imageWidth = $this->_imageData[0];
        $imageHeight = $this->_imageData[1];

        $waterMarkData = getimagesize($this->_watermarkImage);
        switch($waterMarkData['mime'])
        {
            case 'image/gif':
                $watermark =  imagecreatefromgif($this->_watermarkImage);
                break;
                
            case 'image/jpeg':
                $watermark =  imagecreatefromjpeg($this->_watermarkImage);
                break;
                
            case 'image/png':
                $watermark =  imagecreatefrompng($this->_watermarkImage);
                break;
                
            default:
                return FALSE;
        }

        $watermarkWidth = imagesx($watermark);  
        $watermarkHeight = imagesy($watermark);   
 
        $destX = $imageWidth - $watermarkWidth - 5;
        $destY = $imageHeight - $watermarkHeight - 5;  
        imagecopymerge($this->_image , $watermark , $destX , $destY , 0 , 0 , $watermarkWidth , $watermarkHeight , 100);  
        $this->_thumb = $this->_image;
        
        imagedestroy($watermark);
        
        return TRUE;
    }

    /**
    * Save the output
    *
    * @access	    public
    * @param        string  path
    * @param        string  type
    * @return	    boolean
    */

    public function save($path , $type = NULL)
    {
        if($type == NULL)
        {
            switch($this->_imageData['mime'])
            {
                case 'image/gif':
                    imagegif($this->_thumb , $path);
                    break;
                    
                case 'image/jpeg':
                    imagejpeg($this->_thumb , $path);
                    break;
                    
                case 'image/png':
                    imagepng($this->_thumb , $path);
                    break;
                    
                default:
                    return FALSE;
            }
        }
        else
        {    
            $function = 'image' . $type;
            $$function($this->_thumb , $path);
            return TRUE;
        }
    }
}

// END Image Manipulation class

/* End of file Image.php 
   Location: ./system/library/Benchmark.php */