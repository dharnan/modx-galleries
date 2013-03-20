<?php
/**
 * @package gallery
 * @subpackage processors
 */
class GalleryRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'Gallery';
    public $languageTopics = array('galleries:default');
    public $objectType = 'galleries.gallery';
}
return 'GalleryRemoveProcessor';
