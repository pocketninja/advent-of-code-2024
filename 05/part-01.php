<?php
declare(strict_types=1);

chdir(__DIR__);

['rules' => $rules, 'sequences' => $sequences] = require('_read-input.php');

$answer = 0;

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
        continue;
    }

    $midIndex = floor(count($sequence) / 2);

    printf("\n-> valid sequence: %s; [%d] => %d",
        implode(',', $sequence),
        $midIndex, $sequence[$midIndex],
    );

    $answer += $sequence[$midIndex];
}

file_put_contents('answer-part-01.txt', $answer);

printf("\n => Answer is: %d\n", $answer);
