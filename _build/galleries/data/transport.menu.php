<?php
/**
 * Adds modActions and modMenus into package
 *
 * @package galleries
 * @subpackage build
 */
$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id'            => 1,
    'namespace'     => 'galleries',
    'parent'        => 0,
    'controller'    => 'index',
    'haslayout'     => true,
    'lang_topics'   => 'galleries:default',
    'assets'        => '',
        ), '', true, true);

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text'          => 'galleries',
    'parent'        => 'components',
    'description'   => 'galleries.desc',
    'icon'          => 'images/icons/plugin.gif',
    'menuindex'     => 0,
    'params'        => '',
    'handler'       => '',
        ), '', true, true);
$menu->addOne($action);
unset($menus);

return $menu;
