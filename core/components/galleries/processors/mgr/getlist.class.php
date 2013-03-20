<?php
/**
 * Get a list of gallerys
 *
 * @package gallerys
 * @subpackage processors
 */
class GalleryGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'Gallery';
    public $languageTopics = array('galleries:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'galleries.gallery';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'name:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
}
return 'GalleryGetListProcessor';
