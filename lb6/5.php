<?php

$number = (int)trim(fgets(STDIN));
$result = 1;

for ($i = 1; $i <= $number; $i++) {
    $result *= $i;
}
echo $result . PHP_EOL;
?>