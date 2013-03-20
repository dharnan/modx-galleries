<?php

/**
 * GalleryService
 *
 * @package    gallery
 * @copyright  Copyright (c) 2009 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt   GNU License Version 3
 */
class GalleryService
{

    protected $_base_server_path = null;
    protected $_gallery_dir = null;
    protected $_image_list = null;
    protected $_file_dir = null;
    protected $_file_list = null;
    protected $_item_list = null;
    protected $_valid_image_extensions = array('gif', 'jpg', 'jpeg', 'png'); //can be multiple
    protected $_valid_file_extension = array('zip'); //single only

    public function __construct($basePath, $galleryDir, $fileDir)
    {
        $this->_base_server_path = $basePath;
        $this->_gallery_dir = $galleryDir;
        $this->_file_dir = $fileDir;

        $this->_image_list = $this->setImageUrls();
        $this->_file_list = $this->setFileUrls();
        $this->_item_list = $this->mergeImageAndFileUrls();
    }

    /**
     *
     */
    public function getItems()
    {
        return $this->_item_list;
    }

    /**
     *
     */
    public function getImageUrls()
    {
        return $this->_image_list;
    }

    /**
     *
     */
    public function getFileUrls()
    {
        return $this->_file_list;
    }

    /**
     *
     */
    private function setImageUrls()
    {
        $items = array();
        if ($this->_gallery_dir) {
            $pathToImages = realpath($this->_base_server_path . '/' . $this->_gallery_dir);
            //check for images in the gallery folder
            if ($pathToImages && $handle = opendir($pathToImages)) {
                while (false !== ($file = readdir($handle))) {
                    $fileInfo = pathinfo(realpath($pathToImages . '/' . $file));
                    if (isset($fileInfo['extension']) && in_array(strtolower($fileInfo['extension']), $this->_valid_image_extensions)) {
                        $imageWebPath = $this->_gallery_dir . $file;
                        array_push($items, $imageWebPath);
                    }
                }
            }
        }
        return $items;
    }

    /**
     *
     */
    private function setFileUrls()
    {
        $items = array();
        if ($this->_file_dir) {
            $pathToImages = realpath($this->_base_server_path . '/' . $this->_file_dir);
            //check for files in the file folder
            if ($pathToImages && $handle = opendir($pathToImages)) {
                while (false !== ($file = readdir($handle))) {
                    $fileInfo = pathinfo(realpath($pathToImages . '/' . $file));
                    if (isset($fileInfo['extension']) && in_array(strtolower($fileInfo['extension']), $this->_valid_file_extension)) {
                        $fileWebPath = $this->_file_dir . $file;
                        array_push($items, $fileWebPath);
                    }
                }
            }
        }
        return $items;
    }

    /**
     *
     */
    private function mergeImageAndFileUrls()
    {
        $array = array();
        if (null !== $this->_file_list && null !== $this->_image_list) {
            foreach ($this->_image_list as $imageUrl) {
                $array[$imageUrl] = false; //imageUrl => false
                foreach ($this->_file_list as $fileUrl) {
                    if (stristr(basename($imageUrl), basename($fileUrl, 'zip'))) {
                        $array[$imageUrl] = $fileUrl; //imageUrl => fileUrl
                        unset($fileUrl);
                    }
                }
            }
        }
        return $array;
    }

    public function getRandomImageSrc()
    {
        $index = rand(0, count($this->_image_list) - 1);
        return $this->_image_list[$index];
    }

}
