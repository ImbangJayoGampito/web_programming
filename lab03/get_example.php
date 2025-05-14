<?php
// get_example.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET Method Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .result {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Demonstrasi $_GET Superglobal</h1>
    <p>Klik salah satu link di bawah ini untuk mengirim parameter via URL:</p>
    <ul>
        <li><a href="?nama=Budi&jurusan=Informatika&semester=3">Student: Budi</a></li>
        <li><a href="?nama=Ani&jurusan=Sistem Informasi&semester=5">Student: Ani</a></li>
        <li><a href="?nama=Dodi&jurusan=Teknik Komputer&semester=7">Student: Dodi</a></li>
    </ul>
    <?php
    if (!empty($_GET)) {
        echo "<div class='result'>";
        echo "<h3>Data yang diterima:</h3>";
        echo "<p>Nama: " . (isset($_GET['nama']) ? $_GET['nama'] : "Tidak ada") . "</p>";
        echo "<p>Jurusan: " . (isset($_GET['jurusan']) ? $_GET['jurusan'] : "Tidak ada") .
            "</p>";
        echo "<p>Semester: " . (isset($_GET['semester']) ? $_GET['semester'] : "Tidak ada") .
            "</p>";
        echo "<h3>Isi array \$_GET:</h3>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
        echo "</div>";
    }
    ?>
    <h2>Membuat URL dengan Parameter Sendiri</h2>
    <form action="" method="get">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama"><br><br>
        <label for="jurusan">Jurusan:</label>
        <input type="text" id="jurusan" name="jurusan"><br><br>
        <label for="semester">Semester:</label>
        <input type="number" id="semester" name="semester"><br><br>
        <input type="submit" value="Kirim via GET">
    </form>
</body>

</html>