<?php
// Function to calculate the Collatz conjecture for a single number
function collatzCalculation($x) {
    $sequence = array(); // Array to store the sequence
	//Initialize iteration count and max value with starting number
    $maxValue = $x; 
    $iterations = 0; 

    while ($x != 1) {
        if ($x % 2 == 0) {
            // x is even
            $x = $x / 2;
        } else {
            // x is odd
            $x = (3 * $x) + 1;
        }
        $sequence[] = $x; // Add the current value to the sequence
        $maxValue = max($maxValue, $x); // Update max value
        $iterations++; // Increment iteration count
    }

    return array(
        'originalInput' => $x,
        'sequence' => $sequence,
        'maxValue' => $maxValue,
        'iterations' => $iterations
    );
}

// Function to calculate the Collatz conjecture for a range of numbers
function collatzRangeCalculation($start, $finish) {
    $results = array();

    if ($start > $finish) {
        // Switvh start and finish if start is greater than finish
        list($start, $finish) = array($finish, $start);
    }

    for ($i = $start; $i <= $finish; $i++) {
        $result = collatzCalculation($i);
        $results[$i] = array(
            'sequence' => $result['sequence'], // Include the sequence
            'maxValue' => $result['maxValue'],
            'iterations' => $result['iterations']
        );
    }

    return $results;
}

// Function to find the number with max and min iterations and the highest value
function analyzeResults($results) {
    if (empty($results)) {
        return array(
            'numberWithMaxIterations' => null,
            'numberWithMinIterations' => null,
            'numberWithHighestValue' => null
        );
    }

    $maxIterations = $results[array_key_first($results)]['iterations'];
    $minIterations = $results[array_key_first($results)]['iterations'];
    $highestValue = $results[array_key_first($results)]['maxValue'];
    $numberWithMaxIterations = array_key_first($results);
    $numberWithMinIterations = array_key_first($results);
    $numberWithHighestValue = array_key_first($results);

    foreach ($results as $number => $result) {
        if ($result['iterations'] > $maxIterations) {
            $maxIterations = $result['iterations'];
            $numberWithMaxIterations = $number;
        }
        if ($result['iterations'] < $minIterations) {
            $minIterations = $result['iterations'];
            $numberWithMinIterations = $number;
        }
        if ($result['maxValue'] > $highestValue) {
            $highestValue = $result['maxValue'];
            $numberWithHighestValue = $number;
        }
    }

    return array(
        'numberWithMaxIterations' => $numberWithMaxIterations,
        'numberWithMinIterations' => $numberWithMinIterations,
        'numberWithHighestValue' => $numberWithHighestValue
    );
}
?>