<?php
declare(strict_types=1);

chdir(__DIR__);

$list = fopen('./input/list.txt', 'r');

$listA = [];
$listB = [];

while ($line = fgets($list)) {
    [$a, $b] = preg_split('`\s+`', $line);
    $listA[] = $a;
    $listB[] = $b;
}

fclose($list);

$listBCounts = array_count_values($listB);

$similarityScores = array_map(
    fn($location) => $location * ($listBCounts[$location] ?? 0),
    $listA,
);

$similarityScore = array_sum($similarityScores);

file_put_contents('answer-part-02.txt', $similarityScore);

printf("\n => Answer is: %d\n", $similarityScore);