<?php
echo '<channel id="wakuwakujapan">' . PHP_EOL;
echo '<display-name>Waku Waku Japan</display-name>' . PHP_EOL;
echo '<icon src="https://www.wakuwakujapan.com/fileadmin/res/ogp.png" />' . PHP_EOL;
echo '<url>https://www.wakuwakujapan.com</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$json = file_get_contents('https://www.wakuwakujapan.com/json/en/tz0700/');
$content = json_decode($json, true);
foreach ($content as $key => $value) {
        $name = $value["title_en"];
        $name = htmlspecialchars($name);
        $dateStart = $value["start"];
        $dateStop = $value["end"];
        $epnum = $value["ep"];
        $genre = $value["genre"];
        echo '<programme start="' . $dateStart . '00 +0700" stop="' . $dateStop . '00 +0700" channel="wakuwakujapan">' . PHP_EOL;
        echo '<title>' . $name . '</title>' . PHP_EOL;
        echo '<episode-num system="xmltv_ns">0.' . (($epnum != '0') ? ($epnum-1) : '0') . '</episode-num>' . PHP_EOL;
        echo '<desc>Episode ' . (($epnum != '0') ? $epnum : 'Unknown') . ' | Genre: ' . (($genre != '') ? $genre : 'Unknown') . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
};
?>
