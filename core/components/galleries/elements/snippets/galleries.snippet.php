<?php

/**
 * gallery snippet
 *
 * @author     Arietis Software <code@arietis-software.com>
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt   GNU License Version 3
 *
 * @package galleries
 *
 * @params
 * filterStr            (string)
 * sortStr              (string)
 *
 * @todo
 *
 */

$hasDevCorePath = $modx->getOption('dev.core_path', null, false);
if (false !== $hasDevCorePath) { //in development
    error_reporting(8191);
    ini_set('display_errors', true);
}

//clean Script Properties, cast (string)true|false to boolean
foreach ($scriptProperties as $property => &$val) {
    if ($val == 'true') {
        $val = true;
    } elseif ($val == 'false') {
        $val = false;
    }
}

//global paths
$corePath = $modx->getOption(
    'dev.core_path',
    null,
    $modx->getOption('core_path')) . 'components/galleries/';

$assetsUrl = $modx->getOption(
    'dev.assets_url',
    null,
    $modx->getOption('assets_url')) . 'components/galleries/';

$galleriesService = $modx->getService(
    'galleries',
    'Galleries',
    $corePath . 'model/galleries/', $scriptProperties);

if (!($galleriesService instanceof Galleries))
    return '';

//incl paths
$paths = array(
    realpath($galleriesService->config['libPath']),
    get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $paths));

//snippet params
$filterStr = $modx->getOption('filterStr', $scriptProperties, false); //default no filter
$sortStr = $modx->getOption('sortStr', $scriptProperties, false); //default no sort

//request vars
$galleryId = (isset($_GET['gallery-id'])) ? intval($_GET['gallery-id']) : false; //used as get param only

//global vars
$basePath = $modx->getOption('base_path', null, false);
if (!$basePath)
    return;
$start = (isset($_GET['start'])) ? intval($_GET['start']) : 0;
$limit = (isset($_GET['limit'])) ? intval($_GET['limit']) : 20;

//service params
//uses MediaSources

$filePath = realpath($modx->getOption('galleries_file_path', null, false));
$fileUrl = $modx->getOption('galleries_file_url', null, false);

if (!$filePath || !$fileUrl)
    die('The system setting: "galleries_file_path" and/or "galleries_file_url" are not set. Please set them.');
if (substr($filePath, -1, 1) != '/') {
    $filePath = $filePath . '/';
}
if (substr($fileUrl, -1, 1) != '/') {
    $fileUrl = $fileUrl . '/';
}

//smarty init
$modx->getService('smarty', 'smarty.modSmarty');
$modx->smarty->setTemplatePath($galleriesService->config['smartyPath']);

//global css
$modx->regClientCSS($galleriesService->config['cssUrl'] . 'galleries.css');

//gallery model
$c = $modx->newQuery('Gallery');

//filters
if (!$filterStr) { //unfiltered published events
    $whereArr['published'] = 1;
} else { //add where criteria/filter
    $filterArr = explode(';', $filterStr);
    foreach ($filterArr as $pair) {
        $capture = preg_split('/[!:=<>LIKE]+/', $pair, null, PREG_SPLIT_OFFSET_CAPTURE);
        $key = substr($pair, 0, $capture[1][1]);
        if (substr($key, -1, 1) == ':') { //eg: id:1
            $key = substr($key, 0, strlen($key) - 1);
        } elseif (substr($key, -2, 2) == ':=') { //eg. id:=1
            $key = substr($key, 0, strlen($key) - 2);
        }
        $val = $capture[1][0];
        $whereArr[$key] = $val;
    }
}
//if asking for a single event through GET, we need to set it
if ($galleryId && is_int($galleryId)) {
    $whereArr['id'] = $galleryId;
}
$c->where($whereArr);

//sorting
if (!empty($sortStr)) {
    $sortArr = explode(';', $sortStr);
    foreach ($sortArr as $pair) {
        $pairArr = explode(':', $pair);
        $c->sortby($pairArr[0], $pairArr[1]);
    }
}

if (array_key_exists('id', $whereArr) || ($galleryId && is_int($galleryId))) { //Show Gallery Detail

    //css
    $modx->regClientCSS($galleriesService->config['cssUrl'] . 'fancybox.css');

    //javascript
    $modx->regClientScript('http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');
    $modx->regClientScript($galleriesService->config['jsUrl'] . 'jquery.fancybox-1.3.4.pack.js');
    $modx->regClientScript($galleriesService->config['jsUrl'] . 'jquery.easing-1.3.pack.js');
    $modx->regClientScript($galleriesService->config['jsUrl'] . 'jquery.mousewheel-3.0.4.pack.js');
    $modx->regClientScript($galleriesService->config['jsUrl'] . 'galleries.js');

    //fetch row
    $c->limit(1);
    $galleries = $modx->getCollection('Gallery', $c);

    //build array of gallery data
    $row = array();
    foreach ($galleries as $gallery) {
        $row = $gallery->toArray();
    }

    //gallery images and files
    require_once 'GalleryService.class.php';
    $galleryService = new GalleryService($filePath, $row['image_folder'], $row['file_folder']);

    //allow file download?
    $modx->smarty->assign('name', $row['name']);
    $modx->smarty->assign('baseWebPath', $fileUrl);
    $modx->smarty->assign('allowFileDownload', ($row['allow_file_download'] == 'true') ? true : false);
    $modx->smarty->assign('items', $galleryService->getItems());

    if (is_int($galleryId)) {
        $modx->smarty->assign('isFromList', true);
        $modx->smarty->assign('backHref', $modx->makeUrl($modx->resource->get('id')));
    }

    $output = $modx->smarty->fetch('galleryDetail.smarty.tpl');

} else { //Show Gallery List

    //gallery images and files
    if (!class_exists('GalleryService')) {
        require_once 'GalleryService.class.php';
    }

    //build pagination template
    if (!class_exists('Pagination')) {
        require_once 'Pagination.php';
    }
    $count = $modx->getCount('Gallery',$c);
    $p = new Pagination($modx, $count, $start, $limit);

    $modx->smarty->assign('currPageNum', $p->getCurrPageNum());
    $modx->smarty->assign('prevPgHref', $p->getPrevPgHref());
    $modx->smarty->assign('docUrl', $modx->makeUrl($modx->resource->get('id')));
    $modx->smarty->assign('limit', $limit);
    $modx->smarty->assign('numPages', $p->getNumPages());
    $modx->smarty->assign('nextPgHref', $p->getNextPgHref());

    $paginationHtml = $modx->smarty->fetch('pagination.smarty.tpl');

    //limit (includes pagination)
    $c->limit($limit, $start);

    //Iterator
    $galleries = $modx->getCollection('Gallery', $c);

    $rows = array();
    foreach ($galleries as $gallery) {
        $row = $gallery->toArray();
        $row['href'] = $modx->makeUrl($modx->resource->get('id'), '', '&gallery-id=' . $row['id'], 'full');
        $galleryService = new GalleryService($filePath, $row['image_folder'], $row['file_folder']);
        $row['thumb_src'] = $fileUrl . $galleryService->getRandomImageSrc();
        array_push($rows, $row);
        unset($galleryService);
    }

    $modx->smarty->assign('pagination', $paginationHtml);
    $modx->smarty->assign('rows', $rows);
    $output = $modx->smarty->fetch('galleryList.smarty.tpl');
}

return $output;
