<?php
$first = trim(fgets(STDIN));
$second = trim(fgets(STDIN));

while ((int)$first <= (int)$second) {
    $str = str_pad((string)$first, 6, "0", STR_PAD_LEFT);

    if ($str[0] + $str[1] + $str[2] == $str[3] + $str[4] + $str[5]) {
        echo $str . PHP_EOL;
    }
    $first = (int)$first + 1;
}
?>