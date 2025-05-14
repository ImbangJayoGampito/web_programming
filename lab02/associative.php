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
    $student = array(
        "nama" => "Budi Santoso",
        "nim" => "12345678",
        "jurusan" => " Informatika",
        "ipk" => 3.75
    );
    // Cara 2 (sintaks pendek)
    $student = [
        "nama" => "Budi Santoso",
        "nim" => "12345678",
        "jurusan" => "Informatika",
        "ipk" => 3.75
    ];
    // Mengakses elemen array asosiatif
    echo $student["nama"]; // Output: Budi Santoso
    echo "<br>";
    echo $student["jurusan"]; // Output: Teknik Informatika
    ?>
</body>

</html>