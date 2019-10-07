<?php
error_reporting(0);
include ('simplehtmldom/simple_html_dom.php');
header("Content-type: text/plain");
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<tv>' . PHP_EOL;
echo '<channel id="Animax">' . PHP_EOL;
echo '<display-name lang="id">Animax</display-name>' . PHP_EOL;
echo '<icon src="https://mncvision.id/userfiles/image/channel/Animax_150x150.png" />' . PHP_EOL;
echo '<url>http://www.mncvision.id</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$animax = file_get_html('https://www.animax-asia.com/schedule');
$arr = $animax->find('li.listing');
foreach ($arr as $key => $element) {
    $next = $arr[$key + 1];
    if (!empty($next)) {
        $name = $element->find('.content .title', 0)->plaintext;
        $date = date("Ymd", strtotime($element->find('.time-date', 0)->plaintext));
        $clockStart = date("His", strtotime($element->find('.date', 0)->plaintext));
        $clockStop = date("His", strtotime($next->find('.date', 0)->plaintext));
        $meta = $element->find('.meta', 0)->plaintext;
        $synopsis = $element->find('.synopsis', 0)->plaintext;
        echo '<programme start="' . $date . $clockStart . ' +0800" stop="' . $date . $clockStop . ' +0800" channel="Animax">' . PHP_EOL;
        echo '<title lang="id">' . trim($name) . '</title>' . PHP_EOL;
        echo '<episode-num system="onscreen">' . $meta . '</episode-num>' . PHP_EOL;
        echo '<desc lang="id">' . trim($synopsis) . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
    };
};
echo '<channel id="Aniplus">' . PHP_EOL;
echo '<display-name lang="id">Aniplus</display-name>' . PHP_EOL;
echo '<icon src="https://yt3.ggpht.com/a/AGF-l79YsoZVK1aj6CRvWer4DIDVum199mkL4PA9qQ=s900-c-k-c0xffffffff-no-rj-mo" />' . PHP_EOL;
echo '<url>http://www.aniplus-asia.com</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$aniplus = file_get_html('https://www.aniplus-asia.com/tv-schedule/');
$arr_days = $aniplus->find('.vc_tta-panel');
foreach ($arr_days as $days) {
    $dates = $days->getAttribute('id');
    $arr_elements = $days->find('.wpsm-tbody tr');
    foreach ($arr_elements as $key => $element) {
        if (strcmp($dates, 'day1_schedule') == 0) {
            $date = date("Ymd", time());
        } else if (strcmp($dates, 'day2_schedule') == 0) {
            $date = date("Ymd", strtotime("+1 day"));
        } else if (strcmp($dates, 'day3_schedule') == 0) {
            $date = date("Ymd", strtotime("+2 day"));
        } else if (strcmp($dates, 'day4_schedule') == 0) {
            $date = date("Ymd", strtotime("+3 day"));
        } else if (strcmp($dates, 'day5_schedule') == 0) {
            $date = date("Ymd", strtotime("+4 day"));
        } else if (strcmp($dates, 'day6_schedule') == 0) {
            $date = date("Ymd", strtotime("+5 day"));
        } else if (strcmp($dates, 'day7_schedule') == 0) {
            $date = date("Ymd", strtotime("+6 day"));
        };
        $name = $element->find('td', 1)->plaintext;
        $meta = $element->find('td', 2)->plaintext . ' ' . $element->find('td', 3)->plaintext;
        $genre = 'Genre: ' . $element->find('td', 4)->plaintext;
        $clockStart = date("His", strtotime($element->find('td', 0)->plaintext));
        $next = $arr_elements[$key + 1];
        if (!empty($next)) {
            $clockStop = date("His", strtotime($next->find('td', 0)->plaintext));
            echo '<programme start="' . $date . $clockStart . ' +0800" stop="' . $date . $clockStop . ' +0800" channel="Aniplus">' . PHP_EOL;
        } else {
            echo '<programme start="' . $date . $clockStart . ' +0800" stop="' . $date . '240000 +0800" channel="Aniplus">' . PHP_EOL;
        };
        echo '<title lang="id">' . trim($name) . '</title>' . PHP_EOL;
        echo '<episode-num system="onscreen">' . $meta . '</episode-num>' . PHP_EOL;
        echo '<desc lang="id">' . trim($genre) . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
    };
};
echo '</tv>';
?>