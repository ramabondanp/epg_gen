<?php
// disable error report
error_reporting(0);

// cache page
$cachefile = $_SERVER['DOCUMENT_ROOT'] . '/epg.xml';
$cachetime = 54000; //15 Hours
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

// main code
include ('simplehtmldom/simple_html_dom.php');
header("Content-type: text/plain");
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<tv>' . PHP_EOL;
include 'channel/animax.php';
include 'channel/aniplus.php';
include 'channel/gemtv.php';
include 'channel/wakuwakujapan.php';
echo '</tv>';
?>