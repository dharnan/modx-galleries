<?php
/**
 * @package galleries
 * @subpackage processors
 */
class GalleryCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'Gallery';
    public $languageTopics = array('galleries:default');
    public $objectType = 'galleries.gallery';

    public function beforeSave() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('galleries.gallery_err_ns_name'));
        }
        $imageFolder = $this->getProperty('image_folder');
        if (empty($imageFolder)) {
            $this->addFieldError('image_folder',$this->modx->lexicon('galleries.gallery_err_ns_name'));
        }
        $fileFolder = $this->getProperty('file_folder');
        $allowFileDownload = $this->getProperty('allow_file_download', 0);
        if (empty($fileFolder) && $allowFileDownload != 0) {
            $this->addFieldError('file_folder',$this->modx->lexicon('galleries.gallery_err_ns_name'));
        }
        return parent::beforeSave();
    }

}
return 'GalleryCreateProcessor';
