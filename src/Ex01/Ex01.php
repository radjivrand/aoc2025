<?php

namespace Aoc2025\Ex01;

use Aoc2025\Main\Exercise;

class Ex01 extends Exercise
{
    protected $counter = 0;
    protected $pointer = 50;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        foreach ($arr as $value) {
            $start = $this->move($value);

        }

        echo "Counter is: {$this->counter}\n";
    }

    public function move(string $val) {
        $dir = "R";
        $number = trim($val, "R");
        
        if (!is_numeric($number)) {
            $dir = "L";
            $number = trim($val, "L");
        }

        // echo "Dir: {$dir}, number: {$number}\n";

        foreach (range(1, $number) as $click) {
            if ($dir == 'R') {
                $this->right();
            } else {
                $this->left();
            }

            // echo $this->pointer . "\n";

            if ($this->pointer == 0) {
                $this->counter++;
            }
        }
    }

    public function right() {
        $this->pointer++;

        if ($this->pointer == 100) {
            $this->pointer = 0;
        }
    }

    public function left() {
       $this->pointer--;
       
        if ($this->pointer == -1) {
            $this->pointer = 99;
        }
    }
}
