<?php
/**
 * @package gallery
 * @subpackage processors
 */
class GalleryUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'Gallery';
    public $languageTopics = array('galleries:default');
    public $objectType = 'galleries.gallery';

    public function beforeSave() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('galleries.gallery_err_ns_name'));
        }
        return parent::beforeSave();
    }
}
return 'GalleryUpdateProcessor';
