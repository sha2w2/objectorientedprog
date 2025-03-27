<?php
require_once 'collatzcal.php';

class CollatzHistogram extends Collatz {

    const DEFAULT_NUMBER_OF_BINS = 10;
    const ITERATION_KEY = 'iterations';

    /**
     * Calculates the histogram of the number of iterations for a range of numbers.
     *
     * @param int $start The starting number of the range.
     * @param int $finish The ending number of the range.
     * @param int|null $numBins The desired number of bins in the histogram (optional).
     * @return array An array representing the histogram, where keys are bin ranges
     *               and values are the frequency of iteration counts in that range.
     */
    public static function calculateIterationHistogram(int $start, int $finish, ?int $numBins = null): array
    {
        if ($start <= 0 || $finish <= 0 || $start > $finish) {
            return ['error' => 'Please enter a valid positive range.'];
        }

        $iterationsCount = [];
        for ($i = $start; $i <= $finish; $i++) {
            $collatz = new Collatz($i);
            $collatz->calculateSingle();
            $iterationsCount[] = $collatz->getIterations();
        }

        if (empty($iterationsCount)) {
            return [];
        }

        $minIterations = min($iterationsCount);
        $maxIterations = max($iterationsCount);
        
        // Adjust number of bins for small ranges
        $rangeSize = $maxIterations - $minIterations;
        $numBins = $numBins ?? min(self::DEFAULT_NUMBER_OF_BINS, $rangeSize + 1);
        
        // If all values are the same, just return one bin
        if ($rangeSize === 0) {
            return ["[$minIterations]" => count($iterationsCount)];
        }

        // For very small ranges, use each value as its own bin
        if ($rangeSize < 5) {
            $histogram = [];
            foreach ($iterationsCount as $count) {
                $binKey = "[$count]";
                if (!isset($histogram[$binKey])) {
                    $histogram[$binKey] = 0;
                }
                $histogram[$binKey]++;
            }
            ksort($histogram);
            return $histogram;
        }

        // For larger ranges, use the standard binning approach
        $binSize = ceil(($maxIterations - $minIterations + 1) / $numBins);
        $histogram = [];

        foreach ($iterationsCount as $count) {
            $binIndex = floor(($count - $minIterations) / $binSize);
            $binStart = $minIterations + ($binIndex * $binSize);
            $binEnd = $binStart + $binSize - 1;
            $binKey = "[$binStart - $binEnd]";

            if (!isset($histogram[$binKey])) {
                $histogram[$binKey] = 0;
            }
            $histogram[$binKey]++;
        }

        ksort($histogram); 
        return $histogram;
    }
}
?>