<?php
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/gallery.class.php');
class Gallery_mysql extends Gallery
{
    public function __construct(& $xpdo)
    {
        parent :: __construct($xpdo);
    }
}
