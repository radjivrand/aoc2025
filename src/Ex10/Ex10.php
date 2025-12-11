<?php

namespace Aoc2025\Ex10;

use Aoc2025\Main\Exercise;

class Ex10 extends Exercise
{
    protected const RANDOM_ATTEMPTS = 20;

    protected array $sets;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->splitInput($inputArr);

        $this->run($inputArr);
    }

    public function run($arr)
    {
        foreach ($this->sets as $set) {
            $startingButton = 0;

            $dice = $this->rollDice(count($set['switches']) - 1);

            $counter = 0;
            foreach ($dice as $switchIndex) {
                $switch = $set['switches'][$switchIndex];

                $a = bindec($startingButton);
                $b = bindec($switch);


                echo "checking conversion for: {$a} and {$b}, switch no is {$switchIndex}: {$switch}\n";

                $res = $a & $b;

                echo "result is {$res} \n";

                $resString = decbin($res);

                echo "startingButton: {$startingButton} & switch: {$switch} = {$resString}\n";
                $startingButton = bindec($res);

            }
            

        }
    }

    function rollDice($amount) {
        $res = [];

        for ($i=0; $i < self::RANDOM_ATTEMPTS; $i++) { 
            $res[] = rand(0, $amount);
        }

        return $res;
    }

    function splitInput($arr) {
        foreach ($arr as $row) {
            $set = [];
            $things = explode(' ', $row);

            $set['button'] = $this->buttonToBinary(array_shift($things));
            $set['length'] = strlen($set['button']) - 2;
            $set['joltage'] = array_pop($things);
            $set['switches'] = $this->getSwitches($things, $set['button']);       
            
            $this->sets[] = $set;
        }
    }

    function getSwitches($arr, $button) {
        $length = strlen($button) - 2;

        array_walk($arr, function (&$elem) use ($length) {
            $elem = preg_replace('/[\(\)]/', '', $elem);
            $arr = explode(',', $elem);

            $binStr = '0b';

            foreach (range(0, $length - 1) as $index) {
                $binStr .= in_array($index, $arr) ? '1' : '0';
            }

            $elem = $binStr;
        });

        return $arr;
    }

    function buttonToBinary($inputString) {
        $splat = str_split($inputString, 1);
        array_pop($splat);
        array_shift($splat);

        $binString = '0b';

        foreach ($splat as $value) {
            $binString .= ($value == '.' ? '0' : '1');
        }

        return (binary)$binString;
    }
}
