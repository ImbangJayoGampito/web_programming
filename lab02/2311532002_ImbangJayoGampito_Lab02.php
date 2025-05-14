<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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

        div {
            column-count: 2;
        }

        #bottom {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>
        Kartu Rencana Studi
    </h1>
    <div>
        <?php
        function show_grade($student)
        {

            echo '<p>' . 'Nama: ' . $student["name"] . '</p>';
            echo '<p>' . 'NIM: ' . $student["nim"] . '</p>';
            echo '<p>' . 'Program Studi: ' . $student["major"] . '</p>';
            echo '<p>' . 'Semester: ' . $student["semester"] . '</p>';
        }

        $data = [
            "name" => "Budi Santoso",
            "nim" => "TI12345",
            "major" => "Informatika",
            "semester" => 4,
            "subjects" => [
                [
                    "code" => "IF2101",
                    "name" => "Pemrograman Web",
                    "sks" => 3,
                    "grades" => [
                        "assigment" => 85,
                        "uts" => 78,
                        "uas" => 88
                    ]
                ],
                [
                    "code" => "IF2102",
                    "name" => "Algoritma dan Struktur Data",
                    "sks" => 4,
                    "grades" => [
                        "assigment" => 90,
                        "uts" => 85,
                        "uas" => 82
                    ]
                ],
                [
                    "code" => "IF2103",
                    "name" => "Basis Data",
                    "sks" => 3,
                    "grades" => [
                        "assigment" => 78,
                        "uts" => 75,
                        "uas" => 80
                    ]
                ],
                [
                    "code" => "IF2104",
                    "name" => "Jaringan Komputer",
                    "sks" => 3,
                    "grades" => [
                        "assigment" => 88,
                        "uts" => 70,
                        "uas" => 75
                    ]
                ],
                [
                    "code" => "IF2105",
                    "name" => "Sistem Operasi",
                    "sks" => 3,
                    "grades" => [
                        "assigment" => 95,
                        "uts" => 90,
                        "uas" => 92
                    ]
                ],
                [
                    "code" => "IF2106",
                    "name" => "Matematika Diskrit",
                    "sks" => 2,
                    "grades" => [
                        "assigment" => 75,
                        "uts" => 68,
                        "uas" => 70
                    ]
                ]
            ]
        ];
        show_grade($data);
        ?>
    </div>

    <table>
        <tr>

            <th>Kode</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Tugas (20%)</th>
            <th>UTS (40%)</th>
            <th>UAS (40%)</th>
            <th>Nilai Akhir</th>
            <th>Grade</th>
        </tr>
        <?php
        foreach ($data['subjects'] as $subject):

        ?>
            <tr>
                <td><?php echo $subject['code']; ?></td>
                <td><?php echo $subject['name']; ?></td>
                <td><?php echo $subject['sks']; ?></td>

                <?php
                $division_percentage = [
                    "assigment" => 20,
                    "uts" => 40,
                    "uas" => 40
                ];

                $avg = 0;
                foreach ($subject["grades"] as $index => $value) {
                    echo '<td>' . $value . '</td>';
                    $avg += $value * $division_percentage[$index] / 100;
                }
                echo '<td>' . number_format((float)$avg, 2, '.', '') . '</td>';
                $grade = "E";
                $colour_show = "#f83838cc";
                $letter_requirement = [
                    "A" => ["grade_required" => 85, "colour" => "#4ae652cc"],
                    "A-" => ["grade_required" => 80, "colour" => "#4ae652cc"],
                    "B+" => ["grade_required" => 75, "colour" => "#cfe749cc"],
                    "B" => ["grade_required" => 70, "colour" => "#cfe749cc"],
                    "B-" => ["grade_required" => 65, "colour" => "#cfe749cc"],
                    "C+" => ["grade_required" => 60, "colour" => "#eabd46cc"],
                    "C" => ["grade_required" => 55, "colour" => "#eabd46cc"],
                    "D" => ["grade_required" => 45, "colour" => "#eb9445cc"]
                ];
                foreach ($letter_requirement as $letter => $grade) {
                    if ($avg >= $grade['grade_required']) {
                        $grade = $letter;

                        break;
                    }
                }
                $colour_show = $letter_requirement[$grade]["colour"];
                echo '<td style=' . "background-color:$colour_show;" . '>' . $grade . '</td>'                ?>
            </tr>
        <?php endforeach; ?>


    </table>
</body>

</html>