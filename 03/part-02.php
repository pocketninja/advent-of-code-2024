<?php
declare(strict_types=1);

chdir(__DIR__);

$memory = file_get_contents('./input/memory.txt');

$memorySegments = preg_split(
    pattern: '`(do\(\)|don\'t\(\))`',
    subject: $memory,
    flags: PREG_SPLIT_DELIM_CAPTURE
);

$segmentTotals = [];

$include = true;

for ($i = 0; $i < count($memorySegments); $i++) {
    $memorySegment = $memorySegments[$i];

    printf("\n-> %s", $memorySegment);

    $include = match ($memorySegment) {
        'don\'t()' => false,
        'do()' => true,
        default => $include
    };

    if ($memorySegment === 'don\'t()' || $memorySegment === 'do()') {
        continue;
    }

    if (!$include) {
        continue;
    }

    preg_match_all('`mul\((\d+),(\d+)\)`', $memorySegment, $instructions);

    $segmentResults = array_map(
        fn($a, $b) => $a * $b,
        $instructions[1],
        $instructions[2],
    );

    $segmentTotals[] = $segmentTotal = array_sum($segmentResults);

    printf(
        "\n[%d] Segment length: %d; instructions: %d; total: %d",
        $i,
        strlen($memorySegment),
        count($instructions[1]),
        $segmentTotal,
    );
}

$total = array_sum($segmentTotals);

file_put_contents('answer-part-02.txt', $total);

printf("\n => Answer is: %d\n", $total);
