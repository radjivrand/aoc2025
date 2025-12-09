<?php

namespace Aoc2025\Ex06;

use Aoc2025\Main\Exercise;

/**
 * 
 */
class Ex06 extends Exercise
{
    public $map = [];
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        // $res = $this->run($inputArr);
        $res = $this->runPartTwo($inputArr);

        echo "result: {$res}\n";
    }
    
    function runPartTwo($arr) {
        $res = [];
        foreach ($arr as $row) {
            $res[] = str_split($row);
        }

        $operations = array_pop($res);

        $numbers = [];
        $result = 0;

        foreach (range(0, count($operations) - 1) as $key) {
            if ($operations[$key] != ' ') {
                if (!empty($numbers)) {
                    $result += $op == '*' ? array_product($numbers) : array_sum($numbers);
                }

                $op = $operations[$key];
                $numbers = [];
            }

            $newNumber = trim(implode('', array_column($res, $key)));

            if ($newNumber != '') {
                $numbers[] = $newNumber;
            }
        }

        $result += $op == '*' ? array_product($numbers) : array_sum($numbers);

        return $result;
    }

    public function run($arr)
    {
        $arr = $this->cleanup($arr);
        $operations = array_pop($arr);

        $res = 0;

        foreach ($operations as $key => $op) {
            switch ($op) {
                case '*':
                    $localRes = array_product(array_column($arr, $key));
                    break;
                case '+':
                    $localRes = array_sum(array_column($arr, $key));
                    break;                        
                default:
                    break;
            }

            $res += $localRes;
        }

        return $res;
    }
    
    function cleanup($arr) {
        $res = [];
        foreach ($arr as $row) {
            $res[] = preg_split('/\s+/', trim($row));
        }
        
        return $res;
    }
}
