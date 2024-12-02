<?php
declare(strict_types=1);

chdir(__DIR__);

$list = fopen('./input/reports.txt', 'r');

$safeReports = 0;

while ($line = fgets($list)) {
    $line = trim($line);
    $report = preg_split('`\s+`', $line);

    try {
        $increasing = $report[0] < $report[1];

        if ($report[0] === $report[1]) {
            throw new \Exception(sprintf('Distance problem in first values: %d => %d = 0', $report[0], $report[1]));
        }

        for ($i = 0; $i < count($report) - 1; $i++) {
            $a = $report[$i];
            $b = $report[$i + 1];

            if ($a === $b) {
                throw new \Exception('Multiple sequential values: '.$a);
            }

            if ($increasing && $a > $b) {
                throw new \Exception(sprintf('Decreasing value in increasing report: %d !< %d', $a, $b));
            }

            if (!$increasing && $a < $b) {
                throw new \Exception(sprintf('Increasing value in decreasing report: %d !> %d', $a, $b));
            }

            $distance = abs($a - $b);

            if ($distance < 1 || $distance > 3) {
                throw new \Exception(sprintf('Distance problem: %d => %d = %d', $a, $b, $distance));
            }
        }

        $safeReports++;

        printf("\nSafe report: %s", $line);
    } catch (\Exception $e) {
        printf(sprintf("\nUnsafe report: %s; %s", $line, $e->getMessage()));
    }
}

file_put_contents('answer-part-01.txt', $safeReports);

printf("\n => Answer is: %d\n", $safeReports);