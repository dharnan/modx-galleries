<?php
require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
/**
 * Encapsulates the interaction of MODx manager with an HTTP request.
 *
 * {@inheritdoc}
 *
 * @package galleries
 * @extends modRequest
 */
class galleriesControllerRequest extends modRequest {
    public $gallery = null;
    public $actionVar = 'action';
    public $defaultAction = 'index';

    function __construct(Galleries &$galleries) {
        parent :: __construct($galleries->modx);
        $this->galleries =& $galleries;
    }

    /**
     * Extends modRequest::handleMgrRequest and loads the proper error handler and
     * actionVar value.
     *
     * {@inheritdoc}
     */
    public function handleMgrRequest() {
        $this->loadErrorHandler();

        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;

        $modx =& $this->modx;
        $galleries =& $this->galleries;
        $viewHeader = include $this->galleries->config['corePath'].'controllers/mgr/header.php';

        $f = $this->galleries->config['corePath'].'controllers/mgr/'.$this->action.'.php';
        if (file_exists($f)) {
            $viewOutput = include $f;
        } else {
            $viewOutput = 'Controller not found: '.$f;
        }

        return $viewHeader.$viewOutput;
    }
}
