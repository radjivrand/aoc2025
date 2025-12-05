<?php

namespace Aoc2025\Ex02;

use Aoc2025\Main\Exercise;

class Ex02 extends Exercise
{
    protected $counter = 0;
    protected $pointer = 50;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $inputArr = implode('', $inputArr);
        $inputArr = explode(',', $inputArr);
        
        echo $this->run($inputArr) . "\n";
    }

    public function run($arr)
    {
        $sum = 0;

        foreach ($arr as $range) {
            foreach (range(explode('-', $range)[0], explode('-', $range)[1]) as $value) {
                if ($this->isInvalidSecond($value)) {
                    $sum += $value;
                }
            }
        }

        return $sum;
    }

    public function isInvalidFirst($value) : bool {
        if (strlen($value) % 2 != 0) {
            return false;
        }

        $chunks = str_split($value, strlen($value) / 2);

        if ($this->allChunksEqual($chunks)) {
            return true;
        }

        return false;
    }

    public function isInvalidSecond($value) : bool {
        $halfLength = round(strlen($value) / 2, 0, PHP_ROUND_HALF_DOWN);

        for ($i=1; $i <= $halfLength ; $i++) {
            $chunks = str_split($value, $i);

            if ($this->allChunksEqual($chunks)) {
                return true;
            }
        }

        return false;
    }

    public function allChunksEqual(array $arr) : bool {
        foreach (range(1, count($arr) - 1) as $pos) {
            if ($arr[$pos] != $arr[$pos - 1]) {
                return false;
            }            
        }

        return true;
    }
}
