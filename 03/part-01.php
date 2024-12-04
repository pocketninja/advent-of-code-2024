<?php
declare(strict_types=1);

chdir(__DIR__);

$memory = file_get_contents('./input/memory.txt');

preg_match_all('`mul\((\d+),(\d+)\)`', $memory, $instructions);

$results = array_map(
    fn($a, $b) => $a * $b,
    $instructions[1],
    $instructions[2],
);

$total = array_sum($results);

file_put_contents('answer-part-01.txt', $total);

printf("\n => Answer is: %d\n", $total);
