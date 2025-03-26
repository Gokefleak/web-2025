<?php
function getZodiacSign($day, $month) {
    $zodiac = [
        [20, "Козерог", "Водолей"],
        [19, "Водолей", "Рыбы"],
        [20, "Рыбы", "Овен"],
        [20, "Овен", "Телец"],
        [21, "Телец", "Близнецы"],
        [21, "Близнецы", "Рак"],
        [22, "Рак", "Лев"],
        [23, "Лев", "Дева"],
        [23, "Дева", "Весы"],
        [23, "Весы", "Скорпион"],
        [22, "Скорпион", "Стрелец"],
        [21, "Стрелец", "Козерог"]
    ];
    
    return ($day <= $zodiac[$month - 1][0]) ? $zodiac[$month - 1][1] : $zodiac[$month - 1][2];
}

$input = trim(fgets(STDIN));
list($day, $month, $year) = explode(".", $input);

echo getZodiacSign((int)$day, (int)$month);
?>