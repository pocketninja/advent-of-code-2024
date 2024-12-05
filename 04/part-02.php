<?php
declare(strict_types=1);

chdir(__DIR__);

$grid = file_get_contents('./input/word-search.txt');

$grid = array_map(
    fn(string $line) => str_split($line),
    preg_split('`\s+`', $grid),
);

$total = 0;

$maxY = count($grid);
$maxX = count($grid[0]);

for ($x = 0; $x < $maxX; $x++) {
    for ($y = 0; $y < $maxY; $y++) {

        $letter = $grid[$x][$y];

        if ($letter !== 'A') {
            continue;
        }

        echo sprintf("\n --> searching from %s,%s...", $x, $y);

        $wordA = sprintf('%s%s%s',
            $grid[$x - 1][$y - 1] ?? '.',
            $letter,
            $grid[$x + 1][$y + 1] ?? '.',
        );

        $wordB = sprintf('%s%s%s',
            $grid[$x - 1][$y + 1] ?? '.',
            $letter,
            $grid[$x + 1][$y - 1] ?? '.',
        );

        if (($wordA === 'MAS' || $wordA === 'SAM') && ($wordB === 'MAS' || $wordB === 'SAM')) {
            printf("\n     -> %s ; %s", $wordA, $wordB);
            $total++;
        }
    }
}


file_put_contents('answer-part-02.txt', $total);

printf("\n => Answer is: %d\n", $total);
