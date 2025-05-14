<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Data mahasiswa dalam bentuk array asosiatif
    $students = [
        [
            "nim" => "TI001",
            "name" => "Budi Santoso",
            "major" => "Informatika",
            "grade" => [85, 90, 78, 82]
        ],
        [
            "nim" => "TI002",
            "name" => "Anisa Rahma",
            "major" => "Informatika",
            "grade" => [88, 85, 90, 92]
        ],
        [
            "nim" => "SI001",
            "name" => "Dimas Prayoga",
            "major" => "Sistem Informasi",
            "grade" => [78, 80, 85, 75]
        ],
        [
            "nim" => "SI002",
            "name" => "Ratna Dewi",
            "major" => "Sistem Informasi",
            "grade" => [92, 88, 85, 90]
        ]
    ];
    // Hitung rata-rata nilai untuk setiap mahasiswa
    function hitungRataRata($grade)
    {
        return array_sum($grade) / count($grade);
    }
    // Menampilkan data dalam bentuk tabel HTML
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        arifan rahman - Web Programming Genap 2024/2025
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,
initial-scale=1.0">
        <title>Data Mahasiswa</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>
    </head>

    <body>
        <h2>Data Mahasiswa</h2>
        <table>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Nilai Rata-rata</th>
                <th>Grade</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <?php
                $rataRata = hitungRataRata($student["grade"]);
                // Tentukan grade berdasarkan nilai rata-rata
                if ($rataRata >= 90) {
                    $grade = "A";
                } elseif ($rataRata >= 80) {
                    $grade = "B";
                } elseif ($rataRata >= 70) {
                    $grade = "C";
                } elseif ($rataRata >= 60) {
                    $grade = "D";
                } else {

                    $grade = "E";
                }
                ?>
                <tr>
                    <td><?= $student["nim"] ?></td>
                    <td><?= $student["name"] ?></td>
                    <td><?= $student["major"] ?></td>
                    <td><?= number_format($rataRata, 2) ?></td>
                    <td><?= $grade ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>

    </html>
</body>

</html>