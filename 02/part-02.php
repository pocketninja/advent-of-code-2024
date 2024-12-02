<?php
declare(strict_types=1);

chdir(__DIR__);

$list = fopen('./input/reports.txt', 'r');

$safeReports = 0;

function assertReport(array $report): void
{
    $increasing = $report[0] < $report[1];

    if ($report[0] === $report[1]) {
        throw new \Exception( sprintf('Distance problem in first values: %d => %d = 0', $report[0], $report[1]));
    }

    for ($i = 0; $i < count($report) - 1; $i++) {
        $a = $report[$i];
        $b = $report[$i + 1];

        if ($a === $b) {
            throw new \Exception('Multiple sequential values: '.$a, $i);
        }

        if ($increasing && $a > $b) {
            throw new \Exception(sprintf('Decreasing value in increasing report: %d !< %d', $a, $b), $i);
        }

        if (!$increasing && $a < $b) {
            throw new \Exception(sprintf('Increasing value in decreasing report: %d !> %d', $a, $b), $i);
        }

        $distance = abs($a - $b);

        if ($distance < 1 || $distance > 3) {
            throw new \Exception(sprintf('Distance problem: %d => %d = %d', $a, $b, $distance), $i);
        }
    }
}

while ($line = fgets($list)) {
    $line = trim($line);
    $report = preg_split('`\s+`', $line);

    try {
        assertReport($report);

        $safeReports++;

        printf("\nSafe report: %s", $line);
    } catch (\Exception $e) {
        printf("\nPotentially unsafe report: %s; %s", $line, $e->getMessage());

        // Iterate each level, to remove and test without a level.

        $pass = false;
        $adjustedLine = '';
        $adjustedReport = [];

        for ($i = 0; $i < count($report); $i++) {
            $adjustedReport = $report;
            unset($adjustedReport[$i]);
            $adjustedReport = array_values($adjustedReport);

            $adjustedLine = implode(' ', $adjustedReport);

            try {
                printf("\n -> attempting adjusted report: %s", $adjustedLine);
                assertReport($adjustedReport);
                $pass = true;
                break;
            } catch (\Exception $e) {

            }
        }

        if ($pass) {
            printf("\n -> Adjusted safe report: %s", $adjustedLine);
            $safeReports++;
        } else {
            printf("\n !-> No adjusted reports were safe from report: %s", $line);
        }
    }
}

file_put_contents('answer-part-02.txt', $safeReports);

printf("\n => Answer is: %d\n", $safeReports);