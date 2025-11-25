<?php
/**
 * Fungsi untuk mencetak teks.
 * 
 * @param string $teks  Nilai string yang ingin dicetak.
 * @param bool   $bold  Argumen opsional, jika true maka teks akan dicetak tebal.
 */
function print_teks($teks, $bold = true) {
    // Jika $bold bernilai true, teks akan dicetak tebal (bold)
    // Jika false, teks akan dicetak biasa (reguler)
    echo $bold ? '<b>' . $teks . '</b>' : $teks;
    echo "<br>"; // Tambahkan baris baru agar hasilnya rapi di browser
}

// Pemanggilan fungsi
print_teks('Indonesiaku');        // Mencetak dengan huruf tebal (default)
print_teks('Indonesiaku', false); // Mencetak dengan huruf reguler
?>
