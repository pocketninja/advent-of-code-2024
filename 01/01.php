<?php
declare(strict_types=1);

chdir(__DIR__);

$list = fopen('./input/list.txt', 'r');

$listA = [];
$listB = [];
$distances = [];

while ($line = fgets($list)) {
    [$a, $b] = preg_split('`\s+`', $line);
    $listA[] = $a;
    $listB[] = $b;
}

sort($listA);
sort($listB);

$distances = array_map(
    fn($locationA, $locationB) => abs($locationA - $locationB),
    $listA,
    $listB
);

$distance = array_sum($distances);

file_put_contents('answer.txt', $distance);

printf("\n => Answer is: %d\n", $distance);