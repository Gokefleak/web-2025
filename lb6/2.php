<?php
$dictionary = [
    1 => "один",
    2 => "два",
    3 => "три",
    4 => "четыре",
    5 => "пять",
    6 => "шесть",
    7 => "семь",
    8 => "восемь",
    9 => "девять",
    0 => "ноль",
];
$key = (int)trim(fgets(STDIN));
if (array_key_exists($key, $dictionary)) {
    echo $dictionary[$key];
} else {
    echo "'$key' не цифра";
}
?>