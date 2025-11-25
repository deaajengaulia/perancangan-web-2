<?php
$a = 10; $b = 5;

if ($a > $b) {
  echo "a lebih besar dari b\n";
} elseif ($a == $b) {
  echo "a sama dengan b\n";
} else {
  echo "a kurang dari b\n";
}

// switch dengan rentang (pattern switch(true))
$nilai = 78;
switch (true) {
  case ($nilai >= 85):
    echo "Grade: A\n"; break;
  case ($nilai >= 70):
    echo "Grade: B\n"; break;
  case ($nilai >= 55):
    echo "Grade: C\n"; break;
  default:
    echo "Grade: D/E\n";
}
?>
