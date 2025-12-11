<?php

namespace Aoc2025\Ex09;

use Aoc2025\Main\Exercise;

class Ex09 extends Exercise
{
    public $locations = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        foreach ($inputArr as $row) {
            $this->locations[] = explode(',', $row);
        }
        
        $result = $this->run();
        echo "result: {$result}\n";
    }

    public function run()
    {
        $maxArea = 0;

        foreach ($this->locations as $key => $loc) {
            if ($key < array_key_last($this->locations)) {
                foreach (range($key + 1, count($this->locations) - 1) as $index) {
                    $a = abs($loc[0] - $this->locations[$index][0]) + 1;
                    $b = abs($loc[1] - $this->locations[$index][1]) + 1;

                    $area = $a * $b;

                    if ($area > $maxArea) {
                        $maxArea = $area;
                    }
                }
            }
        }

        return $maxArea;
    }
}
