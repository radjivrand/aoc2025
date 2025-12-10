<?php

namespace Aoc2025\Ex08;

use Aoc2025\Main\Exercise;

class Ex08 extends Exercise
{
    public $boxes = [];
    public $distances = [];
    public $chains = [];

    private const TURNS = 1000;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        foreach ($inputArr as $row) {
            $this->boxes[] = explode(',', $row);
        }

        echo "result: " . $this->run($inputArr) . "\n";
    }

    public function run($arr)
    {
        foreach ($this->boxes as $index => $box) {
            if ($index < array_key_last($this->boxes)) {
                foreach (range($index + 1, count($this->boxes) - 1) as $secondIndex) {
                    $distance = $this->findDistance($box, $this->boxes[$secondIndex]);
                    $this->distances[$index . '-' . $secondIndex] = $distance;
                }
            }
        }

        asort($this->distances);

        $counter = 0;

        foreach ($this->boxes as $key => $box) {
            $this->chains[] = [0 => $key];
        }

        foreach ($this->distances as $pair => $distance) {
            // for part I
            // if ($counter >= SELF::TURNS) {
            //     continue;
            // }

            $candidates = explode('-', $pair);
            if (empty($this->chains)) {
                $this->chains[] = $candidates;
            }

            $firstChain = false;
            $secondChain = false;
            $merged = false;

            foreach ($this->chains as $key => $chain) {
                $intersect = array_intersect($chain, $candidates);

                if (!empty($intersect)) {
                    if ($firstChain === false) {
                        $firstChain = $key;
                    } else {
                        $secondChain = $key;
                    }
                }
            }

            if ($firstChain !== false && $secondChain !== false) {
                $merged = true;
                $this->chains[$firstChain] = array_merge($this->chains[$firstChain], $this->chains[$secondChain]);
                unset($this->chains[$secondChain]);
            } elseif ($firstChain !== false) {
                $this->chains[$firstChain] = array_merge($this->chains[$firstChain], $candidates);
                $this->chains[$firstChain] = array_unique($this->chains[$firstChain]);
            } else {
                $this->chains[] = $candidates;
            }

            // part II
            if ($merged && count($this->chains) == 1) {
                return $this->boxes[$candidates[0]][0] * $this->boxes[$candidates[1]][0];
            }

            $counter++;
        }    

        $scores = array_map(function($elem) {
            return count($elem);
        }, $this->chains);

        rsort($scores);

        return $scores[0] * $scores[1] * $scores[2];
    }

    function findDistance($a, $b) {
        return round(
            sqrt(
                ($a[0] - $b[0])**2
                + ($a[1] - $b[1])**2
                + ($a[2] - $b[2])**2
            ), 4
        );        
    }
}
