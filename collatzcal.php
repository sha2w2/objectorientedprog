<?php
class Collatz {
    // Properties
    private $startNumber;
    private $sequence;
    private $maxValue;
    private $iterations;

    // Constructor
    public function __construct($startNumber) {
        $this->startNumber = $startNumber;
        $this->sequence = [];
        $this->maxValue = $startNumber;
        $this->iterations = 0;
    }

    // Method for a single number calculations
    public function calculateSingle() {
        $num = $this->startNumber;
        $this->sequence = [$num];
        $this->maxValue = $num;
        $this->iterations = 0;

        while ($num != 1) {
            if ($num % 2 == 0) {
                $num = $num / 2;
            } else {
                $num = 3 * $num + 1;
            }
            $this->sequence[] = $num;
            $this->maxValue = max($this->maxValue, $num);
            $this->iterations++;
        }
    }

    // Method for range of numbers calculations
    public static function calculateRange($start, $finish) {
        $results = [];
        for ($i = $start; $i <= $finish; $i++) {
            $collatz = new Collatz($i);
            $collatz->calculateSingle();
            $results[$i] = [
                'sequence' => $collatz->getSequence(),
                'maxValue' => $collatz->getMaxValue(),
                'iterations' => $collatz->getIterations()
            ];
        }
        return $results;
    }

    // Method for a range results statistics
    public static function calculateStatistics($results) {
        $maxIterationsNumber = null;
        $minIterationsNumber = null;
        $maxReachedValueNumber = null;
        $maxIterations = 0;
        $minIterations = PHP_INT_MAX;
        $maxReachedValue = 0;

        foreach ($results as $number => $data) {
            if ($data['iterations'] > $maxIterations) {
                $maxIterations = $data['iterations'];
                $maxIterationsNumber = $number;
            }
            if ($data['iterations'] < $minIterations) {
                $minIterations = $data['iterations'];
                $minIterationsNumber = $number;
            }
            if ($data['maxValue'] > $maxReachedValue) {
                $maxReachedValue = $data['maxValue'];
                $maxReachedValueNumber = $number;
            }
        }

        return [
            'maxIterationsNumber' => $maxIterationsNumber,
            'minIterationsNumber' => $minIterationsNumber,
            'maxReachedValueNumber' => $maxReachedValueNumber,
            'maxIterations' => $maxIterations,
            'minIterations' => $minIterations,
            'maxReachedValue' => $maxReachedValue
        ];
    }

    // The 'gets'
    public function getSequence() {
        return $this->sequence;
    }

    public function getMaxValue() {
        return $this->maxValue;
    }

    public function getIterations() {
        return $this->iterations;
    }
}
?>