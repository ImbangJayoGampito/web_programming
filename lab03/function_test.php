<?php
// menguhubungkan dengan file functions.php
include 'functions.php';
echo "<h2>Pengujian Function</h2>";
// Uji fungsi faktorial
echo "<h3>Faktorial</h3>";
echo "5! = " . faktorial(5) . "<br>";
echo "10! = " . faktorial(10) . "<br>";
// Uji fungsi isPrima
echo "<h3>Cek Bilangan Prima</h3>";
$angka_test = [2, 7, 10, 13, 25, 29];
foreach ($angka_test as $num) {
    echo "$num adalah prima: " . (isPrima($num) ? "Ya" : "Tidak") . "<br>";
}
// Uji fungsi generatePrima
echo "<h3>Generate Bilangan Prima</h3>";
$prima_sampai_50 = generatePrima(50);
echo "Bilangan prima hingga 50: " . implode(", ", $prima_sampai_50) . "<br>";
// Uji fungsi hitungRataRata
echo "<h3>Hitung Rata-rata</h3>";
$nilai = [85, 90, 78, 92, 88];
echo "Nilai: " . implode(", ", $nilai) . "<br>";

echo "Rata-rata: " . hitungRataRata($nilai) . "<br>";
// Uji fungsi calculator
$hasil1 = calculator(10, 5, 'tambah');
$hasil2 = calculator(10, 5, 'kurang');
$hasil3 = calculator(10, 5, 'kali');
$hasil4 = calculator(10, 5, 'bagi');
$hasil5 = calculator(10, 0, 'bagi');
echo "<h2>Kalkulator Sederhana</h2>";
echo "10 + 5 = $hasil1 <br>";
echo "10 - 5 = $hasil2 <br>";
echo "10 * 5 = $hasil3 <br>";
echo "10 / 5 = $hasil4 <br>";
echo "10 / 0 = $hasil5 <br>";
