<?php

class Gallery extends xPDOSimpleObject {
    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    /**
     * Overrides xPDOObject::save to add edited/created auto-filling fields
     *
     * {@inheritDoc}
     */
    public function save($cacheFlag = null) {

        $this->set('name', ucwords($this->name));

        if (isset($this->image_folder) && $this->image_folder == '[none]') {
            $this->set('image_folder', NULL);
        }
        if (isset($this->file_folder) && $this->file_folder == '[none]') {
            $this->set('file_folder', NULL);
        }
        if (isset($this->allow_file_download) && $this->allow_file_download == 'on') {
            $this->set('allow_file_download', 1);
        } else {
            $this->set('allow_file_download', 0); //db default
        }

        $this->set('published', 0); //db default
        if (isset($this->published) && $this->published == 'on') {
            $this->set('published', 1);
        }

        $this->set('datetime_created', date('Y-m-d H:i:s', strtotime('NOW')));
        $this->set('datetime_modified', date('Y-m-d H:i:s', strtotime('NOW')));

        return parent :: save($cacheFlag);
    }
}
