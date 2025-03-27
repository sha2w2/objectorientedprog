<!DOCTYPE html>
<html>
<head>
    <title>3x+1 Calculator</title>
</head>
<body>
    <h1>3x+1 Calculator</h1>

    <!-- Form for single number input -->
    <h2>Single Number Calculation</h2>
    <form method="post">
        Please input integer x: <input type="number" name="x" required>
        <input type="submit" name="single_calculate" value="Calculate">
    </form>

    <!-- Form for range input -->
    <h2>Range Calculation</h2>
    <form method="post">
        Start: <input type="number" name="start" required><br><br>
        Finish: <input type="number" name="finish" required><br><br>
        <input type="submit" name="range_calculate" value="Calculate">
    </form>

    <?php
    // Include the functions file
    require 'functions.php';

    // Process single number form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["single_calculate"])) {
        $x = $_POST["x"];

        // Validate input
        if (!is_numeric($x) || $x <= 0 || (int)$x != $x) {
            echo "<p style='color: red;'>Please enter a valid positive integer.</p>";
        } else {
            $x = (int)$x; 

            // Call the function to calculate the Collatz sequence
            $result = collatzCalculation($x);

            // Output results
            echo "<h2>Results for Input: " . htmlspecialchars($x) . "</h2>";
            echo "<p>Sequence of values: " . htmlspecialchars(implode(", ", $result['sequence'])) . "</p>";
            echo "<p>Maximum value: " . htmlspecialchars($result['maxValue']) . "</p>";
            echo "<p>Total iterations (stopping time): " . htmlspecialchars($result['iterations']) . "</p>";
        }
    }

    // Process range form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["range_calculate"])) {
        $start = $_POST["start"];
        $finish = $_POST["finish"];

        // Validate input
        if (!is_numeric($start) || !is_numeric($finish) || $start <= 0 || $finish <= 0) {
            echo "<p style='color: red;'>Please enter valid positive integers.</p>";
        } else {
            $start = (int)$start;
            $finish = (int)$finish;

            // Call the function to calculate the Collatz sequence for the range
            $results = collatzRangeCalculation($start, $finish);

            // Analyze the results
            $analysis = analyzeResults($results);

            // Output results
            echo "<h2> Results for Range: " . htmlspecialchars($start) . " to " . htmlspecialchars($finish) . "</h2>";
            echo "<p>Number with maximum iterations: " . htmlspecialchars($analysis['numberWithMaxIterations']) . " (" . htmlspecialchars($results[$analysis['numberWithMaxIterations']]['iterations']) . " iterations)</p>";
            echo "<p>Number with minimum iterations: " . htmlspecialchars($analysis['numberWithMinIterations']) . " (" . htmlspecialchars($results[$analysis['numberWithMinIterations']]['iterations']) . " iterations)</p>";
            echo "<p>Number with the highest maximum value: " . htmlspecialchars($analysis['numberWithHighestValue']) . " (Maximum value: " . htmlspecialchars($results[$analysis['numberWithHighestValue']]['maxValue']) . ")</p>";

            // Display detailed results for each number in the range
            echo "<h2>Detailed Results:</h2>";
            foreach ($results as $number => $result) {
                echo "<h3>Number: " . htmlspecialchars($number) . "</h3>";
                echo "<p>Sequence of values: " . htmlspecialchars(implode(", ", $result['sequence'])) . "</p>";
                echo "<p>Maximum value: " . htmlspecialchars($result['maxValue']) . "</p>";
                echo "<p>Total iterations (stopping time): " . htmlspecialchars($result['iterations']) . "</p>";
                echo "<hr>";
            }
        }
    }
    ?>
</body>
</html>