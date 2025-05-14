<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $fruits = ["Apel", "Jeruk", "Mangga", "Pisang"];
    // Menghitung jumlah elemen array
    echo count($fruits); // Output: 4
    echo "<br>";
    echo "<br>";
    // Mengurutkan array
    sort($fruits);
    print_r($fruits); // Output: Array ( [0] => Apel [1] => Jeruk [2] =>Mangga [3] => Pisang )
    echo "<br>";
    echo "<br>";
    // Menambah elemen di akhir array
    array_push($fruits, "Durian");
    print_r($fruits); // Output: Array ( [0] => Apel [1] => Jeruk [2] =>Mangga [3] => Pisang [4] => Durian )
    echo "<br>";
    echo "<br>";
    // Menghapus elemen terakhir
    $last = array_pop($fruits);
    echo $last; // Output: Durian
    echo "<br>";
    echo "<br>";
    // Menggabungkan array
    $vegetables = ["Bayam", "Wortel", "Kangkung"];
    $food = array_merge($fruits, $vegetables);
    print_r($food);
    echo "<br>";
    echo "<br>";
    // Mencari nilai dalam array

    $position = array_search("Mangga", $fruits);
    echo $position; // Output: indeks dimana "Mangga" berada
    echo "<br>";
    echo "<br>";
    // Memeriksa keberadaan nilai
    if (in_array("Jeruk", $fruits)) {
        echo "Jeruk ada dalam array";
    }
    ?>as
</body>

</html>