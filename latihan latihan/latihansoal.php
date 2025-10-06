
<?php
// Deret A
$a = [4];
for($i=1; $i<7; $i++){
    $a[] = $a[$i-1] + $i+1; 
}
echo "Deret A: " . implode(", ", $a) . "<br>";

// Deret B
$b = [];
for($i=2; $i<=5; $i++){
    $b[] = $i;
    $b[] = $i;
}
echo "Deret B: " . implode(", ", $b) . "<br>";

// Deret C
$c = [];
for($i=1; $i<=4; $i++){
    $c[] = $i;
    $c[] = $i+8; 
}
echo "Deret C: " . implode(", ", $c) . "<br>";
?>
