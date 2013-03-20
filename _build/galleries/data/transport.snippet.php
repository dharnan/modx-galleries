<?php
/**
 * @package galleries
 * @subpackage build
 */

function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php', '?>'), '', $o));
    return $o;
}
$snippets = array();

/* coure snippets */
$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id'            => 1,
    'name'          => 'Galleries',
    'description'   => 'Displays a list of Galleries.',
    'snippet'       => getSnippetContent($sources['snippets'] . 'galleries.snippet.php'),
),'',true,true);
$properties = include $sources['properties'] . 'properties.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;