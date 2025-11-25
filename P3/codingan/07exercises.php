<?php
// File: 07_exercises.php
function cek_tipe($v){
  if (is_int($v)) return "Tipe: integer, nilai = $v";
  if (is_string($v)) return "Tipe: string, nilai = '$v'";
  if (is_null($v)) return "Variabel bernilai NULL";
  if (is_array($v)) return "Tipe: array, jumlah elemen = ".count($v);
  return "Tipe lain: ".gettype($v);
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><title>07 - Exercises</title></head>
<body>
  <h1>07 - Soal Latihan: cek_tipe()</h1>
  <pre>
<?php
echo cek_tipe(10)."\n";
echo cek_tipe("tes")."\n";
echo cek_tipe(NULL)."\n";
echo cek_tipe([1,2,3])."\n";
?>
  </pre>
</body>
</html>
