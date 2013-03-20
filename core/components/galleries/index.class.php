<?php
/**
 * @package galleries
 * @subpackage controllers
 */
require_once dirname(__FILE__) . '/model/galleries/galleries.class.php';
abstract class GalleriesManagerController extends modExtraManagerController {
    /** @var Galleries $doodles */
    public $galleries;
    public function initialize() {
        $this->galleries = new Galleries($this->modx);

        $this->addCss($this->galleries->config['cssUrl'].'/mgr/mgr.css');
        $this->addJavascript($this->galleries->config['jsUrl'].'mgr/galleries.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Galleries.config = '.$this->modx->toJSON($this->galleries->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('galleries:default');
    }
    public function checkPermissions() { return true;}
}
/**
 * @package galleries
 * @subpackage controllers
 */
class IndexManagerController extends GalleriesManagerController {
    public static function getDefaultController() { return 'home'; }
}
