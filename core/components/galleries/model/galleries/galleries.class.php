<?php
/**
 * @package galleries
 */
class Galleries
{

    public $modx;
    public $config = array();

    /**
     *
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx = & $modx;

        $baseAssetsUrl = $this->modx->getOption('assets_url') . 'components/galleries/';
        $assetsUrl = $this->modx->getOption('dev.assets_url', $config, $this->modx->getOption('assets_url')) . 'components/galleries/';
        $corePath = $this->modx->getOption('dev.core_path', $config, $this->modx->getOption('core_path')) . 'components/galleries/';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'basePath' => $corePath,
            'chunksPath' => $corePath . 'elements/chunks/',
            'connectorUrl' => $baseAssetsUrl . 'connector.php', //must point to base modx b/c of xxs
            'corePath' => $corePath,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'libPath' => $corePath . 'lib/',
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'smartyPath' => $corePath . 'elements/smarty/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'templatesPath' => $corePath . 'templates/',
                        ), $config);

        $this->modx->addPackage('galleries', $this->config['modelPath']);
    }

    /**
     *
     * @param <type> $ctx
     * @return <type>
     */
    public function initialize($ctx = 'web')
    {
        switch ($ctx)
        {
            case 'mgr':
                $this->modx->lexicon->load('galleries:default');

                if (!$this->modx->loadClass('GalleriesControllerRequest', $this->config['modelPath'] . 'galleries/request/', true, true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new GalleriesControllerRequest($this);
                return $this->request->handleMgrRequest();
                break;
        }
        return true;
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name, $properties = array())
    {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk', array('name' => $name));
                if ($chunk == false)
                    return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.$postfix
     * @param string $postfix The default postfix to search for chunks at.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name, $postfix = '.chunk.tpl')
    {
        $chunk = false;
        $f = $this->config['chunksPath'] . strtolower($name) . $postfix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name', $name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

}
