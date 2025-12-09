<?php

namespace Aoc2025\Ex07;

use Aoc2025\Main\Exercise;

/**
 * 905 too low
 */
class Ex07 extends Exercise
{
    public int $splits = 0;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $res = $this->run($inputArr);
        echo "result: {$this->splits}\n";
    }

    public function run($arr)
    {
        $firstRow = array_shift($arr);
        $startLocation = strpos($firstRow, 'S');
        $beams = [$startLocation];

        foreach ($arr as $key => $row) {
            if ($key % 2 == 0) {
                continue;
            }

            $row = str_split($row, 1);

            $newBeams = [];
            foreach ($beams as $location) {
                if ($row[$location] == '^') {
                    $this->splits++;
                    $newBeams[] = $location - 1;
                    $newBeams[] = $location + 1;
                } else {
                    $newBeams[] = $location;
                }
            }

            echo "current key is {$key}\n";
            $beams = array_unique($newBeams);
        }
    }
}
