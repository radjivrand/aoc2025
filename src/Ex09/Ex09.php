<?php

namespace Aoc2025\Ex09;

use Aoc2025\Main\Exercise;

class Ex09 extends Exercise
{
    public $locations = [];
    public $distances = [];
    public $chains = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->getCoordinates($inputArr);
        
        $result = $this->run($inputArr);
        echo "result: {$result}\n";
    }

    public function run($arr)
    {
        $maxArea = 0;

        foreach ($this->locations as $key => $loc) {
            if ($key < array_key_last($this->locations)) {
                foreach (range($key + 1, count($this->locations) - 1) as $index) {
                    


                    echo "testing: \n";
                    print_r($loc);
                    echo "vs\n";
                    print_r($this->locations[$index]);
                   
                }
                # code...
            }
        }
        
        // print_r($this->locations);
    }

    function getCoordinates($arr) {
        foreach ($arr as $rowKey => $row) {
            $splat = str_split($row);
            foreach ($splat as $colKey => $value) {
                if ($value == '#') {
                    $this->locations[] = [$rowKey, $colKey];
                }
            }
        }
    }
}
