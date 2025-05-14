<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Array multidimensi
    $student = [
        [
            "nama" => "Andi",
            "nilai" => [85, 90, 78]
        ],
        [
            "nama" => "Budi",
            "nilai" => [80, 85, 92]
        ],
        [
            "nama" => "Citra",
            "nilai" => [90, 88, 95]
        ]
    ];
    // Mengakses elemen array multidimensi
    echo $student[0]["nama"]; // Output: Andi
    echo $student[2]["nilai"][1]; // Output: 88
    ?>
</body>

</html>