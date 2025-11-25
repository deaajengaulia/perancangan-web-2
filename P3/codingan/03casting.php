<?php
$bil = 3;
$str = "halo";
$nullVar = null;

echo var_export(is_int($bil), true) . "\n";    // true
echo var_export(is_string($str), true) . "\n"; // true
echo var_export(is_null($nullVar), true) . "\n"; // true

// isset
echo var_export(isset($str), true) . "\n";       // true
echo var_export(isset($undefinedVar), true) . "\n"; // false
?>
