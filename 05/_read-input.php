<?php

//$handle = fopen('./input/sample-page-and-rules.txt', 'r');
$handle = fopen('./input/pages-and-rules.txt', 'r');

$rules = [];
$sequences = [];

while (($line = fgets($handle)) !== false) {
    $line = trim($line);

    if (empty($line)) {
        continue;
    }

    if (str_contains($line, '|')) {
        $order = explode('|', $line);

        if (!array_key_exists($order[0], $rules)) {
            $rules[$order[0]] = [];
        }

        $rules[$order[0]][] = $order[1];
    } else {
        if (str_contains($line, ',')) {
            $sequences[] = explode(',', $line);
        }
    }
}

return compact('rules', 'sequences');

