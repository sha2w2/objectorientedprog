<!DOCTYPE html>
<html>
<head>
<title>3xplus1</title>
</head>
<body>

<h1>3x+1</h1>

<form method="post">
  Please input integer x:
  <input type="number" name="x">
  <input type="submit" value="Calculate">
</form>

<?php 
// Get x, make sure x is positive, store x as integer
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
$x = $_POST["x"];

if (!is_numeric($x) || (int) 
	$x != $x || $x <= 0) {
		echo "Positive integers only.";
	exit; }
  
  $x = $_POST["x"];


  if (is_numeric($x) && (int)$x == $x) {
    $x = (int)$x; 
    
    $sequence = array(); // Array to store the sequence
    $original_x = $x; // Store the original value for output.

    while ($x != 1) {
      
      if ($x % 2 == 0) {
        // x is even
        $sequence[] = $x; 
        $x = $x / 2;
        
      } else {
        // x is odd
        $sequence[] = $x;
        $x = (3 * $x) + 1;
         
      }
    }
    $sequence[] = 1; // Add the final 1 to the sequence


    echo implode(", ", $sequence); // Output the sequence 
    echo "</p>";
  }
  }

?>

</body>
</html>