<?php
declare(strict_types=1);

chdir(__DIR__);

$grid = file_get_contents('./input/pages-and-rules.txt');


$answer = 0;

file_put_contents('answer-part-02.txt', $answer);

printf("\n => Answer is: %d\n", $answer);
