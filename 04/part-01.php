<?php
declare(strict_types=1);

chdir(__DIR__);

$grid = file_get_contents('./input/word-search.txt');

$grid = array_map(
    fn(string $line) => str_split($line),
    preg_split('`\s+`', $grid),
);

$directions = [
    'up' => [0, 1],
    'up-right' => [1, 1],
    'right' => [1, 0],
    'down-right' => [1, -1],
    'down' => [0, -1],
    'down-left' => [-1, -1],
    'left' => [0, -1],
    'left-up' => [-1, 1],
];

$total = 0;

// @todo - iterate x and y, when find 'x', search in all directions.

//file_put_contents('answer-part-01.txt', $total);

printf("\n => Answer is: %d\n", $total);
