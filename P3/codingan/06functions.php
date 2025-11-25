<?php
// File: 06_functions.php
function tambah($a,$b=0){ return $a+$b; }
function cetak($t,$upper=false){ echo $upper?strtoupper($t):$t; }
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><title>06 - Functions</title></head>
<body>
  <h1>06 - Fungsi & Argumen Default</h1>
  <p>tambah(2,3) = <?php echo tambah(2,3); ?></p>
  <p>tambah(5) = <?php echo tambah(5); ?> (b default = 0)</p>

  <h3>Contoh cetak()</h3>
  <pre><?php cetak("Halo dunia\n"); cetak("Halo Besar\n", true); ?></pre>
</body>
</html>
