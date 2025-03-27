<?php
require 'collatzcal.php';

//form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['single_number'])) {
        // Single number calculation
        $number = intval($_POST['single_number']);
        if ($number > 0) {
            $collatz = new Collatz($number);
            $collatz->calculateSingle();
            $sequence = $collatz->getSequence();
            $maxValue = $collatz->getMaxValue();
            $iterations = $collatz->getIterations();
        } else {
            $error = "Please enter a valid positive integer.";
        }
    } elseif (isset($_POST['start']) && isset($_POST['finish'])) {
        // Range calculation
        $start = intval($_POST['start']);
        $finish = intval($_POST['finish']);
        if ($start > 0 && $finish > 0 && $start <= $finish) {
            $results = Collatz::calculateRange($start, $finish);
            $statistics = Collatz::calculateStatistics($results);
        } else {
            $error = "Please enter valid start and finish values.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3x+1 Problem</title>
</head>
<body>
    <h1>3x+1 Problem Calculator</h1>

    <!-- Single Number Form -->
    <form method="post">
        <h2>Single Number Calculation</h2>
        <label for="single_number">Enter a number:</label>
        <input type="number" name="single_number" id="single_number" required>
        <button type="submit">Calculate</button>
    </form>

    <!-- Range Calculation Form -->
    <form method="post">
        <h2>Range Calculation</h2>
        <label for="start">Start:</label>
        <input type="number" name="start" id="start" required>
        <label for="finish">Finish:</label>
        <input type="number" name="finish" id="finish" required>
        <button type="submit">Calculate Range</button>
    </form>

    <!-- Display Results -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (isset($sequence)): ?>
        <h2>Results for Single Number <?php echo htmlspecialchars($number); ?></h2>
        <p>Sequence: <?php echo implode(', ', $sequence); ?></p>
        <p>Max Value: <?php echo htmlspecialchars($maxValue); ?></p>
        <p>Iterations: <?php echo htmlspecialchars($iterations); ?></p>
    <?php endif; ?>

    <?php if (isset($results)): ?>
        <h2>Results for Range <?php echo htmlspecialchars($start); ?> to <?php echo htmlspecialchars($finish); ?></h2>
        <h3>Statistics</h3>
        <p>Number with Max Iterations: <?php echo htmlspecialchars($statistics['maxIterationsNumber']); ?> (<?php echo htmlspecialchars($statistics['maxIterations']); ?> iterations)</p>
        <p>Number with Min Iterations: <?php echo htmlspecialchars($statistics['minIterationsNumber']); ?> (<?php echo htmlspecialchars($statistics['minIterations']); ?> iterations)</p>
        <p>Number with Max Reached Value: <?php echo htmlspecialchars($statistics['maxReachedValueNumber']); ?> (<?php echo htmlspecialchars($statistics['maxReachedValue']); ?>)</p>

        <h3>Detailed Results</h3>
        <?php foreach ($results as $number => $data): ?>
            <h4>Number: <?php echo htmlspecialchars($number); ?></h4>
            <p>Sequence: <?php echo implode(', ', $data['sequence']); ?></p>
            <p>Max Value: <?php echo htmlspecialchars($data['maxValue']); ?></p>
            <p>Iterations: <?php echo htmlspecialchars($data['iterations']); ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>