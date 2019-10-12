<?php
echo '<channel id="Aniplus">' . PHP_EOL;
echo '<display-name lang="id">Aniplus</display-name>' . PHP_EOL;
echo '<icon src="https://pbs.twimg.com/profile_images/884675389859090432/ZZ_PwKWt_400x400.jpg" />' . PHP_EOL;
echo '<url>http://www.aniplus-asia.com</url>' . PHP_EOL;
echo '</channel>' . PHP_EOL;
$content = file_get_html('https://www.aniplus-asia.com/tv-schedule/');
$arr_days = $content->find('.vc_tta-panel');
foreach ($arr_days as $days) {
    $dates = $days->getAttribute('id');
    $arr_elements = $days->find('.wpsm-tbody tr');
    foreach ($arr_elements as $key => $element) {
        $timezone  = 3600*(+8);
        if (strcmp($dates, 'day1_schedule') == 0) {
            $date = date("Ymd", time() + $timezone);
        } else if (strcmp($dates, 'day2_schedule') == 0) {
            $date = date("Ymd", strtotime("+1 day") + $timezone);
        } else if (strcmp($dates, 'day3_schedule') == 0) {
            $date = date("Ymd", strtotime("+2 day") + $timezone);
        } else if (strcmp($dates, 'day4_schedule') == 0) {
            $date = date("Ymd", strtotime("+3 day") + $timezone);
        } else if (strcmp($dates, 'day5_schedule') == 0) {
            $date = date("Ymd", strtotime("+4 day") + $timezone);
        } else if (strcmp($dates, 'day6_schedule') == 0) {
            $date = date("Ymd", strtotime("+5 day") + $timezone);
        } else if (strcmp($dates, 'day7_schedule') == 0) {
            $date = date("Ymd", strtotime("+6 day") + $timezone);
        };
        $name = $element->find('td', 1)->plaintext;
        $name = htmlspecialchars($name);
        $epNum = $element->find('td', 2)->plaintext;
        $meta = $element->find('td', 3)->plaintext;
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
        echo '<episode-num system="xmltv_ns">0.' . ($epNum - 1) . '</episode-num>' . PHP_EOL;
        echo '<desc lang="id">Episode ' . $epNum . ', ' . $meta . ' | ' . trim($genre) . '</desc>' . PHP_EOL;
        echo '</programme>' . PHP_EOL;
    };
};
?>