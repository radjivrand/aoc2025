<?php

namespace Aoc2025\Ex04;

use Aoc2025\Main\Exercise;

class Ex04 extends Exercise
{
    protected array $map;
    protected int $rollsRemoved;

    public function __construct()
    {
        $this->map = $this->getFileContents();

        foreach ($this->map as &$row) {
            $row = str_split($row);
        }
        
        $initialCount = $this->countRolls($this->map);

        $this->run();

        echo $initialCount - $this->countRolls($this->map) . "\n";
    }

    public function run()
    {
        do {
            $currentCount = $this->countRolls($this->map);
            
            $this->map = $this->getNewMap($this->map);
                        $this->map = $this->removeXs($this->map);
            
            $newCount = $this->countRolls($this->map);

            if ($newCount == $currentCount) {
                return $currentCount;
            }
        } while(true);        
    }

    function removeXs($arr) : array {
        foreach ($arr as &$row) {
            foreach ($row as &$val) {
                $val = $val == 'x' ? '.' : $val;
            }
        }

        return $arr;
    }

    function getNewMap($arr) : array {
        $solvedMap = [];

        foreach ($arr as $rowNr => $row) {
            $newRow = [];
            foreach ($row as $colNr => $val) {
                if ($val == '@') {
                    $newRow[] = $this->hasLessThanFour($rowNr, $colNr) ? 'x' : $val;
                } else {
                    $newRow[] = '.';
                }
            }

            $solvedMap[] = $newRow;
        }

        return $solvedMap;
    }

    function countRolls($map) {
        $counter = 0;

        foreach ($map as $row) {
            foreach ($row as $value) {
                if ($value == '@') {
                    $counter++;
                }
            }
        }

        return $counter;
    }

    function hasLessThanFour($row, $col) {
        $counter = 0;

        if (($this->map[$row - 1][$col - 1] ?? '-') == '@') {
            $counter++;
        }
        
        if (($this->map[$row - 1][$col] ?? '-') == '@') {
            $counter++;
        }
        
        if ((($this->map[$row - 1][$col + 1] ?? '-')) == '@') {
            $counter++;
        }
        
        if ((($this->map[$row][$col - 1 ] ?? '-')) == '@') {
            $counter++;
        }
        
        if (($this->map[$row][$col + 1] ?? '-') == '@') {
            $counter++;
        }
        
        if (($this->map[$row + 1][$col - 1] ?? '-') == '@') {
            $counter++;
        }
        
        if (($this->map[$row + 1][$col] ?? '-') == '@') {
            $counter++;
        }

        if (($this->map[$row + 1][$col + 1] ?? '-') == '@') {
            $counter++;
        }

        return $counter < 4;
    }

    function printMap($arr) {
        foreach ($arr as $row) {
            echo implode("", $row) . "\n";
        }
    }
}
