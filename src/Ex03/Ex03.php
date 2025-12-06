<?php

namespace Aoc2025\Ex03;

use Aoc2025\Main\Exercise;

/**
 * too low: 26922215
 */
class Ex03 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $sum = 0;

        foreach ($arr as $line) {
            // $sum += $this->getLargestPair(str_split($line)); // part I
            $sum += (int)implode($this->getLargestDozen(str_split($line)));
        }

        return $sum;
    }

    public function getLargestPair($arr) {
        $largest = 0;
        $secondLargest = 0;
        $largestKey = null;

        foreach ($arr as $key => $value) {
            if ($value > $largest && $key < count($arr) - 1) {
                $largest = $value;
                $largestKey = $key;
            }
        }
        
        foreach (range($largestKey + 1, count($arr) - 1) as $pos) {
            if ($arr[$pos] > $secondLargest) {
                $secondLargest = $arr[$pos];
            }
        }

        return (int)((string)$largest . (string)$secondLargest);
    }

    public function getLargestDozen($arr) {
        if (count($arr) == 12) {
            return $arr;
        }

        $arr = $this->removeOne($arr);
        return $this->getLargestDozen($arr);        
    }

    function removeOne($arr) : array {
        foreach (range(1, count($arr) - 1) as $pos) {
            if ($arr[$pos - 1] < $arr[$pos]) {
                unset($arr[$pos - 1]);
                return array_values($arr);
            }
            
        }
        
        unset($arr[$pos]);
        return array_values($arr);
    }
}
