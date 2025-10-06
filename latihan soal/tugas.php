<?php
/**
 * psycho_sequences.php
 * Versi: rapi, ringkas, mudah dibaca
 *
 * Cara pakai:
 * - CLI:  php psycho_sequences.php
 * - Web:  letakkan di folder webserver kemudian buka lewat browser
 *
 * Output:
 * - Menampilkan tabel berisi deret awal, pola yang dideteksi, dan dua suku berikutnya,
 *   serta penjelasan singkat tiap pola.
 */

/* ------------------ Detektor pola ------------------ */

/**
 * Deteksi pola: selisih bertambah 1 tiap langkah
 * Contoh: 4,6,9,13,18  -> selisih 2,3,4,5 -> berikutnya +6, +7
 */
function detect_increasing_diff(array $seq): ?array {
    $n = count($seq);
    if ($n < 2) return null;
    $diff = [];
    for ($i = 1; $i < $n; $i++) $diff[] = $seq[$i] - $seq[$i-1];

    // cek apakah perbedaan antar-diff selalu +1
    for ($i = 1; $i < count($diff); $i++) {
        if ($diff[$i] - $diff[$i-1] !== 1) return null;
    }

    // hitung dua suku berikutnya
    $last = $seq[$n-1];
    $lastDiff = $diff[count($diff)-1];
    $out = [];
    for ($k = 0; $k < 2; $k++) {
        $lastDiff += 1;
        $last += $lastDiff;
        $out[] = $last;
    }
    return [
        'pattern' => 'Selisih bertambah +1 tiap langkah',
        'next' => $out,
        'explain' => sprintf("Selisih: %s → lanjut +%d, +%d",
            implode(', ', $diff),
            $diff[count($diff)-1] + 1,
            $diff[count($diff)-1] + 2
        )
    ];
}

/**
 * Deteksi pola: setiap bilangan muncul dua kali berturut-turut
 * Contoh: 2,2,3,3,4 -> ...4,4,5,5...
 */
function detect_repeat_twice(array $seq): ?array {
    $n = count($seq);
    if ($n < 2) return null;

    // bangun deret ideal mulai dari nilai pertama sampai cukup panjang
    $start = $seq[0];
    $ideal = [];
    $val = $start;
    while (count($ideal) < $n + 4) {
        $ideal[] = $val;
        $ideal[] = $val;
        $val++;
    }

    // cek apakah seq cocok dengan awal ideal
    for ($i = 0; $i < $n; $i++) {
        if ($seq[$i] !== $ideal[$i]) return null;
    }

    // next dua suku
    $next = array_slice($ideal, $n, 2);
    return [
        'pattern' => 'Setiap bilangan muncul dua kali berurutan',
        'next' => $next,
        'explain' => sprintf("Deret ideal: %s, ...", implode(', ', array_slice($ideal, 0, min(10, count($ideal)))) )
    ];
}

/**
 * Deteksi pola: deret bergantian antara dua sub-deret (pos ganjil & genap)
 * Contoh: 1,9,2,10,3 -> ganjil:1,2,3 (aritmetika +1), genap:9,10 (aritmetika +1)
 */
function detect_alternating_arithmetic(array $seq): ?array {
    $odd = []; $even = [];
    for ($i = 0; $i < count($seq); $i++) {
        if ($i % 2 === 0) $odd[] = $seq[$i]; // index 0 -> posisi 1 (ganjil)
        else $even[] = $seq[$i];
    }

    $is_arith = function($arr) {
        if (count($arr) < 2) return false;
        $d = $arr[1] - $arr[0];
        for ($i = 2; $i < count($arr); $i++) {
            if ($arr[$i] - $arr[$i-1] !== $d) return false;
        }
        return $d;
    };

    $d_odd = $is_arith($odd);
    $d_even = $is_arith($even);

    if ($d_odd === false || $d_even === false) return null;

    // hitung dua suku berikutnya sesuai posisi
    $nextIndex = count($seq); // next zero-based index
    $next = [];
    $lastOdd = end($odd);
    $lastEven = end($even);
    for ($k = 0; $k < 2; $k++) {
        if ($nextIndex % 2 === 0) { // posisi ganjil (index even)
            $lastOdd += $d_odd;
            $next[] = $lastOdd;
        } else {
            $lastEven += $d_even;
            $next[] = $lastEven;
        }
        $nextIndex++;
    }

    return [
        'pattern' => 'Deret bergantian: dua sub-deret aritmetika (ganjil & genap)',
        'next' => $next,
        'explain' => sprintf("Ganjil: d=%d (%s). Genap: d=%d (%s).",
            $d_odd, implode(', ', $odd),
            $d_even, implode(', ', $even)
        )
    ];
}

/* ------------------ Penyelesai utama ------------------ */

function solve_sequence(array $seq) {
    // urutkan detektor prioritas: increasing_diff -> repeat_twice -> alternating_arithmetic
    $detectors = ['detect_increasing_diff', 'detect_repeat_twice', 'detect_alternating_arithmetic'];
    foreach ($detectors as $fn) {
        $res = $fn($seq);
        if ($res !== null) return $res;
    }
    // fallback: tidak terdeteksi
    return [
        'pattern' => 'Pola tidak dikenali otomatis',
        'next' => ['?', '?'],
        'explain' => 'Perlu analisis manual atau pola lain.'
    ];
}

/* ------------------ Data soal ------------------ */

$soals = [
    'a' => [4,6,9,13,18],
    'b' => [2,2,3,3,4],
    'c' => [1,9,2,10,3]
];

/* ------------------ Output rapi: CLI atau HTML ------------------ */

$isCli = (php_sapi_name() === 'cli');

if ($isCli) {
    // Header CLI
    echo str_repeat('=', 70) . PHP_EOL;
    echo str_pad('Soal', 6) . str_pad('Deret Awal', 30) . str_pad('Polaprediksi', 24) . "Next\n";
    echo str_repeat('-', 70) . PHP_EOL;
    foreach ($soals as $label => $seq) {
        $res = solve_sequence($seq);
        $given = implode(', ', $seq);
        $next = implode(', ', $res['next']);
        echo str_pad("($label)", 6)
            . str_pad($given, 30)
            . str_pad($res['pattern'], 24)
            . $next . PHP_EOL;
        // baris penjelasan singkat
        echo "  -> Penjelasan: " . $res['explain'] . PHP_EOL;
        echo str_repeat('-', 70) . PHP_EOL;
    }
    echo "Catatan: Jika ingin output tanpa penjelasan, ubah variabel atau panggil fungsi sesuai kebutuhan.\n";
    echo str_repeat('=', 70) . PHP_EOL;
} else {
    // Output HTML (jika dibuka lewat browser)
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Psycho Sequences - Hasil</title>";
    echo "<style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}table{border-collapse:collapse;width:100%;max-width:900px}td,th{border:1px solid #ccc;padding:8px;text-align:left}th{background:#f3f3f3}</style>";
    echo "</head><body>";
    echo "<h2>Hasil Deteksi Pola - Tes Psyko</h2>";
    echo "<table><thead><tr><th>Soal</th><th>Deret Awal</th><th>Pola</th><th>2 Suku Berikutnya</th></tr></thead><tbody>";
    foreach ($soals as $label => $seq) {
        $res = solve_sequence($seq);
        echo "<tr>";
        echo "<td>(" . htmlspecialchars($label) . ")</td>";
        echo "<td>" . htmlspecialchars(implode(', ', $seq)) . "</td>";
        echo "<td>" . htmlspecialchars($res['pattern']) . "<br><small>" . htmlspecialchars($res['explain']) . "</small></td>";
        echo "<td>" . htmlspecialchars(implode(', ', $res['next'])) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "<p><em>File ini mendeteksi beberapa pola umum. Untuk pola lain (kuadrat, pangkat, dsb.) bisa ditambahkan.</em></p>";
    echo "</body></html>";
}
?>
