<?php
// Fungsi untuk menghitung faktorial
function faktorial($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return $n * faktorial($n - 1);
    }
}
// Fungsi untuk mengecek bilangan prima
function isPrima($angka)
{
    if ($angka <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($angka); $i++) {
        if ($angka % $i == 0) {
            return false;
        }
    }
    return true;
}
// Fungsi untuk menghasilkan array bilangan prima hingga batas tertentu
function generatePrima($batas)
{
    $hasil = [];
    for ($i = 2; $i <= $batas; $i++) {
        if (isPrima($i)) {
            $hasil[] = $i;
        }
    }
    return $hasil;
}
// Fungsi untuk menghitung rata-rata dari array
function hitungRataRata($arr)
{
    if (empty($arr)) {
        return 0;
    }
    return array_sum($arr) / count($arr);
}

// Calculator
function calculator($angka1, $angka2, $operasi)
{
    switch ($operasi) {
        case 'tambah':
            return $angka1 + $angka2;
        case 'kurang':
            return $angka1 - $angka2;
        case 'kali':
            return $angka1 * $angka2;
        case 'bagi':
            return $angka2 != 0 ? $angka1 / $angka2 : "Error: Pembagian dengan nol";
        default:
            return "Operasi tidak valid";
    }
}
