<?php
echo '<channel id="Waku Waku Japan">' . PHP_EOL;
echo '<display-name lang="id">Waku Waku Japan</display-name>' . PHP_EOL;
echo '<icon src="https://www.wakuwakujapan.com/fileadmin/res/ogp.png" />' . PHP_EOL;
echo '<url>https://www.wakuwakujapan.com</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$json = file_get_contents('https://www.wakuwakujapan.com/json/tz0700/');
$content = json_decode($json, true);
foreach ($content as $key => $value) {
        $name = $value["title_en"];
        $dateStart = $value["start"];
        $dateStop = $value["end"];
        $epnum = $value["ep"];
        $genre = 'Genre: ' . $value["genre"];
        echo '<programme start="' . $dateStart . '00 +0700" stop="' . $dateStop . '00 +0700" channel="Waku Waku Japan">' . PHP_EOL;
        echo '<title lang="id">' . $name . '</title>' . PHP_EOL;
        echo '<episode-num system="xmltv_ns">0.' . $epnum . '</episode-num>' . PHP_EOL;
        echo '<desc lang="id">Episode ' . ($epnum + 1) . ' | ' . $genre . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
};
?>