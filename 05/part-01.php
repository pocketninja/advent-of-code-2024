<?php
declare(strict_types=1);

chdir(__DIR__);

['rules' => $rules, 'sequences' => $sequences] = require('_read-input.php');

$answer = 0;

$fixSequence = function (array $sequence) use ($rules) {
    usort(
        $sequence,
        function ($a, $b) use ($rules) {
            $mustPrecede = $rules[$a] ?? [];
            return in_array($b, $mustPrecede) ? -1 : 1;
        },
    );
    return $sequence;
};

$correctedSequences = [];

foreach ($sequences as $sequence) {
    $pass = true;

    for ($i = 0; $i < count($sequence); $i++) {
        $pageNumber = $sequence[$i];

        if (!array_key_exists($pageNumber, $rules)) {
            throw new Exception(sprintf('Invalid page number, no rule: %s', $pageNumber));
        }

        $pageRule = $rules[$pageNumber];

        for ($x = $i; $x >= 0; $x--) {
            if (in_array($sequence[$x], $pageRule)) {
                printf("\n!! invalid sequence: %s; %d came before %d",
                    implode(',', $sequence),
                    $sequence[$x],
                    $sequence[$i],
                );
                $pass = false;
                break;
            }
        }

        if (!$pass) {
            break;
        }

    }

    if (!$pass) {
        $correctedSequences[] = $fixSequence($sequence);
        continue;
    }

    $midIndex = floor(count($sequence) / 2);

    printf("\n-> valid sequence: %s; [%d] => %d",
        implode(',', $sequence),
        $midIndex, $sequence[$midIndex],
    );

    $answer += $sequence[$midIndex];
}

$correctedSequenceAnswer = 0;
foreach ($correctedSequences as $correctedSequence) {
    $midIndex = floor(count($correctedSequence) / 2);
    $correctedSequenceAnswer += $correctedSequence[$midIndex];

    printf("\n-> corrected sequence: %s; [%d] => %d",
        implode(',', $correctedSequence),
        $midIndex, $correctedSequence[$midIndex],
    );
}

file_put_contents('answer-part-01.txt', $answer);

printf("\n => Answer part one is: %d\n", $answer);


file_put_contents('answer-part-02.txt', $correctedSequenceAnswer);

printf("\n => Answer part two is: %d\n", $correctedSequenceAnswer);
