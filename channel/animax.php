<?php
echo '<channel id="Animax">' . PHP_EOL;
echo '<display-name lang="id">Animax</display-name>' . PHP_EOL;
echo '<icon src="https://www.animax-asia.com/sites/asia.animax/files/animax_logo_endorsed_0.png" />' . PHP_EOL;
echo '<url>http://www.animax-asia.com</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$content = file_get_html('https://www.animax-asia.com/schedule');
$arr = $content->find('li.listing');
foreach ($arr as $key => $element) {
    $next = $arr[$key + 1];
    if (!empty($next)) {
        $name = $element->find('.content .title', 0)->plaintext;
        $name = htmlspecialchars($name);
        $dateStart = date("Ymd", strtotime($element->find('.time-date', 0)->plaintext));
        $dateStop = date("Ymd", strtotime($next->find('.time-date', 0)->plaintext));
        $clockStart = date("His", strtotime($element->find('.date', 0)->plaintext));
        $clockStop = date("His", strtotime($next->find('.date', 0)->plaintext));
        $meta = $element->find('.meta', 0)->plaintext;
        $epnum = preg_match_all("/\d+/", $meta, $epnumArr);
        $synopsis = $element->find('.synopsis', 0)->plaintext;
        echo '<programme start="' . $dateStart . $clockStart . ' +0800" stop="' . $dateStop . $clockStop . ' +0800" channel="Animax">' . PHP_EOL;
        echo '<title lang="id">' . trim($name) . '</title>' . PHP_EOL;
        if (isset($epnumArr[0][1])) {
            echo '<episode-num system="xmltv_ns">' . ($epnumArr[0][0] - 1) . '.' . ($epnumArr[0][1] - 1) . '</episode-num>' . PHP_EOL;
        }else{
            echo '<episode-num system="xmltv_ns">0.' . ($epnumArr[0][0] - 1) . '</episode-num>' . PHP_EOL;
        };
        echo '<desc lang="id">' . $meta . ' | ' . trim($synopsis) . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
    };
};
?>