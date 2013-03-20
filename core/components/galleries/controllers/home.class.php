<?php
/**
 * @package galleries
 * @subpackage controllers
 */
class GalleriesHomeManagerController extends GalleriesManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('galleries'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->galleries->config['jsUrl'].'mgr/widgets/galleries.grid.js');
        $this->addJavascript($this->galleries->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->galleries->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() {
        return $this->galleries->config['templatesPath'].'home.tpl';
    }
}
