<?php
$str = '123abc';
$bil = (int) $str; // hasil 123

echo "Tipe asli: " . gettype($str) . "\n"; // string
echo "Tipe setelah casting: " . gettype($bil) . "\n"; // integer
echo "Nilai bil: $bil\n"; // 123
?>
