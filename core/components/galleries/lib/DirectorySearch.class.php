<?php

/**
 * DirectorySearch
 *
 * The service provides setup for searching directories for a list of folders
 *
 * @package    galleries
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt   GNU License Version 3
 */
class DirectorySearch
{

    protected $_root_dir;

    public function __construct($root_dir = null)
    {
        $this->_root_dir = $root_dir;
    }

    /**
     *
     */
    public function setRootDirectory($root_dir)
    {
        $this->_root_dir = realpath($root_dir);
   }

    /**
     *
     */
    public function getRootDirectory()
    {
        return $this->_root_dir;
    }

    /**
     * # Original PHP code by Chirp Internet: www.chirp.com.au
     */
    public function getDirectoryList($dir, $recurse=false, $depth=false)
    {
        # array to hold return value
        $retval = array();

        # add trailing slash if missing
        if (substr($dir, -1) != "/")
            $dir .= "/";

        # open pointer to directory and read list of files
        $d = @dir($dir) or die("getDirectoryList: Failed opening directory $dir for reading");

        while (false !== ($entry = $d->read())) {

            # skip hidden files
            if ($entry[0] == ".")
                continue;
            # skip mcimagemanager thumb directories (mcith)
            if ($entry == "mcith")
                continue;

            if (is_dir("$dir$entry")) {
                $retval[] = array(
                    "path" => "$dir$entry/",
                    "type" => filetype("$dir$entry"),
                    "size" => 0,
                    "lastmod" => filemtime("$dir$entry")
                );
                if ($recurse && is_readable("$dir$entry/")) {
                    if ($depth === false) {
                        $retval = array_merge($retval, $this->getDirectoryList("$dir$entry/", true));
                    } elseif ($depth > 0) {
                        $retval = array_merge($retval, $this->getDirectoryList("$dir$entry/", true, $depth - 1));
                    }
                }
            } elseif (is_readable("$dir$entry")) {
                $retval[] = array(
                    "path" => "$dir$entry",
                    "type" => filetype("$dir$entry"), //sub for: mime_content_type
                    "size" => filesize("$dir$entry"),
                    "lastmod" => filemtime("$dir$entry")
                );
            }
        }
        $d->close();

        return $retval;
    }

    /**
     *
     */
    public function getImageFileList($directory)
    {
        $files = array();
        if (is_dir($start_dir)) {
            $fh = opendir($start_dir);
            while (($file = readdir($fh)) !== false) {

                // loop through the files, skipping . and .., and recursing if necessary
                if (strcmp($file, '.') == 0 || strcmp($file, '..') == 0)
                    continue;

                $filepath = $start_dir . '/' . $file;
                if (is_dir($filepath)) {
                    $files = array_merge($files, $this->getImageFileList($filepath));
                } else {
                    array_push($files, $filepath);
                }
            }
            closedir($fh);
        } else {
            // false if the function was called with an invalid non-directory argument
            $files = false;
        }

        return $files;
    }

    /**
     *
     */
    public function getDirectoryListAsKeyValuePairs()
    {
        $directories = $this->getDirectoryList($this->_root_dir, true);

        $result_arr = array();
        foreach ($directories as $key => $arr) {
            if ($arr['type'] == 'dir') {
                $path = str_replace($this->_root_dir, '', $arr['path']);
                $result_arr[$path] = $path;
            }
        }

        return $result_arr;
    }

}
