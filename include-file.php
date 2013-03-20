<?php
# Snippet to include files from file system
# USAGE: [[!includeFile? &file=`/my_component/elements/snippets/mysnippet.snippet`]]

if (!isset($file) || $file== "") return "Missing Include file!";

$hasDevPath = $modx->getOption('dev.core_path', null, false);

if(false !== $hasDevPath) { //we're in dev mode!
    $filePath = realpath($hasDevPath . 'components/' . $file);
}

if ($filePath && file_exists($filePath)) {
   $o = include $filePath;
} else { 
   $o = 'Include file not found at: ' . $file;
}
return $o;