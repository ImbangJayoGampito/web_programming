<?php
function hitungLuasSegitiga($alas, $tinggi)
{
    $luas = 0.5 * $alas * $tinggi;
    return $luas;
}
// Memanggil function
$luasSegitiga = hitungLuasSegitiga(6, 4);
echo "Luas segitiga: " . $luasSegitiga . "<br><br>";
// Function dengan parameter default
function sapa($nama = "Pengunjung")
{
    return "Halo, " . $nama . "!<br><br>";
}
echo sapa(); // Output: Halo, Pengunjung!
echo sapa("Budi"); // Output: Halo, Budi!
// Anonymous function
$kaliDua = function ($angka) {
    return $angka * 2;
};
echo $kaliDua(5);
echo "<br><br>";
// Arrow function (PHP 7.4+)
$kuadrat = fn($x) => $x * $x;
echo $kuadrat(4); // Output: 16
echo "<br><br>";
// Function dengan Referensi
function tambahLima(&$nilai)
{
    $nilai += 5;
}
$angka = 10;
tambahLima($angka);
echo $angka; // Output: 15 (nilai berubah karena parameter menggunakan referensi)
