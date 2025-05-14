<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>

<body>
    <?php
    // Cara 1
    $fruits = array("Apel", "Jeruk", "Mangga", "Pisang");
    // Cara 2 (sintaks pendek, PHP 5.4+)
    $fruits = ["Apel", "Jeruk", "Mangga", "Pisang"];
    // Mengakses elemen array
    echo "<p>$fruits[0]</p>"; // Output: Apel
    echo "<p>$fruits[2]</p>"; // Output: Mangga
    ?>
</body>

</html>