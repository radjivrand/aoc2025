<?php

namespace Aoc2025\Ex10;

use Aoc2025\Main\Exercise;

class Ex10 extends Exercise
{
    protected const RANDOM_ATTEMPTS = 20;

    protected array $sets;
    protected array $perms;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->splitInput($inputArr);

        $this->run($inputArr);
    }

    public function run($arr)
    {
        $res = 0;

        foreach ($this->sets as $key => $set) {
            echo "processing set no {$key}...\n";
            $res += $this->findFastestWay($set);
        }

        echo "=============\n";
        echo "best result together is {$res}\n";
    }
    

    function findFastestWay($set) {
        $permCount = count($set['switches']);
                        
        foreach (range(1,8) as $depth) {
            $perms = $this->combinations(range(0, $permCount - 1), $depth);

            foreach ($perms as $perm) {
                $perms = implode(' - ', $perm);
                $buttonState = 0;
    
                foreach ($perm as $try) {
                    $switch = $set['switches'][$try];
                    $state = $buttonState ^ $switch;
        
                    if ($state == $set['button']) {
                        return $depth;
                    }
    
                    $buttonState = $state;
                }
            }
        }

        echo "could not find yet, skippin...\n";
        return 0;
    }

    function combinations($set = [], $size = 0) {
        if ($size == 0) {
            return [[]];
        }

        if ($set == []) {
            return [];
        }

        $prefix = [array_shift($set)];
        $result = [];

        foreach ($this->combinations($set, $size-1) as $suffix) {
            $result[] = array_merge($prefix, $suffix);
        }

        foreach ($this->combinations($set, $size) as $next) {
            $result[] = $next;
        }

        return $result;
    }

    function splitInput($arr) {
        foreach ($arr as $row) {
            $set = [];
            $things = explode(' ', $row);
            $first = array_shift($things);

            $set['button'] = $this->buttonToBinary($first);
            $set['length'] = strlen($first) - 2;
            $set['joltage'] = array_pop($things);
            $set['switches'] = $this->getSwitches($things, $first);
            
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

            $elem = bindec($binStr);
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

        return bindec($binString);
    }
}
