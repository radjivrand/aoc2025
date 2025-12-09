<?php

namespace Aoc2025\Ex05;

use Aoc2025\Main\Exercise;

/**
 * 363447258615552: too high
 * 357674099117260 ? 
 */

class Ex05 extends Exercise
{
    protected array $rules = [];
    protected array $items = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();

        $flag = false;

        foreach ($inputArr as $line) {
            if (null == $line) {
                $flag = true;
                continue;
            }

            if (!$flag) {
                $this->rules[] = explode('-', $line);
            } else {
                $this->items[] = $line;
            }
        }

        // print_r($this->run());
        $this->runOverlaps();

        echo "Result is: " . $this->printResult() . "\n";
    }

    function printResult() {
        $res = 0;
        foreach ($this->rules as $rule) {
            $res += $rule[1] - $rule[0] + 1;
        }

        return $res;
    }

    function runOverlaps() {
        while (true) {
            $res = $this->removeOverlaps();

            if (
                empty($res)
                || $res['replaceKey'] == $res['removeKey']
            ) {
                return;
            }

            $this->rules[$res['replaceKey']] = $res['new'];
            unset($this->rules[$res['removeKey']]);
            $this->rules = array_values($this->rules);
        }
    }

    function removeOverlaps() {
        foreach ($this->rules as $key => $rule) {
            foreach (range($key + 1, count($this->rules) - 1) as $value) {
                if (
                    isset($this->rules[$value])
                    && $this->hasOverlap($rule, $this->rules[$value])
                ) {
                    $res = [
                        'new' =>
                            [
                                min($this->rules[$value][0], $rule[0]),
                                max($this->rules[$value][1], $rule[1]),
                            ],
                        'replaceKey' => $key,
                        'removeKey' => $value,
                    ];

                    return $res;
                }
            }
        }
    }

    function hasOverlap($arr, $brr) {
        return ($arr[0] >= $brr[0] && $arr[0] <= $brr[1])
            || ($arr[0] <= $brr[0] && $arr[1] >= $brr[0]);
    }

    public function run()
    {
        $counter = 0;

        foreach ($this->items as $item) {
            if ($this->isFresh($item)) {
                $counter++;
            }
        }

        return $counter;

    }

    function isFresh($item) {
        foreach ($this->rules as $rule) {
            if ($item >= $rule[0] && $item <= $rule[1]) {
                return true;
            }
        }

        return false;
    }
}
