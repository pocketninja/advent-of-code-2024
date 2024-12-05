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
    'left' => [-1, 0],
    'left-up' => [-1, 1],
];

$total = 0;

$maxY = count($grid);
$maxX = count($grid[0]);

for ($x = 0; $x < $maxX; $x++) {
    for ($y = 0; $y < $maxY; $y++) {

        $letter = $grid[$x][$y];

        if ($letter !== 'X') {
            continue;
        }

        echo sprintf("\n --> searching from %s,%s...", $x, $y);

        foreach ($directions as $directionName => $direction) {

            $word = $letter;

            for ($i = 1; $i <= 3; $i++) {
                $searchX = $x + $direction[0] * $i;
                $searchY = $y + $direction[1] * $i;
                $search = $grid[$searchX][$searchY] ?? '.';
                $word .= $search;
            }

            if ($word !== 'XMAS') {
                continue;
            }

            printf("\n     -> %s: %s", $directionName, $word);

            $total++;
        }

    }
}


file_put_contents('answer-part-01.txt', $total);

printf("\n => Answer is: %d\n", $total);
