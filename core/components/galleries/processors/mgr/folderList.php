<?php

/*
 * @author     Arietis Software <code@arietis-software.com>
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt    GNU License Version 3
 */
if (empty($scriptProperties['which'])) {
    die('invalid access.');
    return;
}

require_once (dirname(dirname(dirname(__FILE__))) . '/lib/DirectorySearch.class.php');

$corePath = $modx->getOption('dev.core_path', null, $modx->getOption('core_path'));
$filesRootPath = $modx->getOption('galleries_file_path', null, false);
if (empty($filesRootPath)) {
    die('please set the galleries_file_path system setting to a folder with read/write permissions');
}
if ($modx->getOption('galleries_file_path_relative', null, 0) == 1) {
    $filesRootPath = realpath($modx->getOption('core_path') . '/../' . $filesRootPath) . '/';
}

$outArr = array();
if (false === $filesRootPath) {
    return json_encode(array(
        'rows' => $outArr
    ));
}

$dSearch = new DirectorySearch($filesRootPath);

$which = $modx->getOption('which', $scriptProperties, 'image');

if ($which == 'image') { //image

    $folders = $dSearch->getDirectoryListAsKeyValuePairs();
    foreach ($folders as $key => $value) {
        array_push($outArr, array(
            'id' => $key,
            'name' => $value
        ));
    }

} else { //file

    $folders = $dSearch->getDirectoryListAsKeyValuePairs();
    foreach ($folders as $key => $value) {
        array_push($outArr, array(
            'id' => $key,
            'name' => $value
        ));
    }
}

//put empty choice at beginning of the array
array_unshift($outArr, array(
    'id'    => 0,
    'name'  => '[none]'
));

return json_encode(array(
    'rows' => $outArr
));
?>
