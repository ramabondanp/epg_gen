<?php
$cachefile = $_SERVER['DOCUMENT_ROOT'] . '/epg.xml';
$cachetime = 18000;

if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    header("Content-type: text/plain");
    readfile($cachefile);
    exit;
}

function cache_page($content) {
    $fileName = $_SERVER['DOCUMENT_ROOT'] . '/epg.xml';
    unlink($fileName);
    $f = fopen($fileName, 'w');
    fwrite($f, $content);
    fclose($f);
    return $content.'';
}

ob_start('cache_page');
?>