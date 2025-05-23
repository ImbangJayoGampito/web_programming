<?php
include './function/Alert.php';
include_once './model/Mahasiswa.php';

$mahasiswa = new Mahasiswa();
$result = $mahasiswa->get_all();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OOP - CRUD</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="text-center">Data Mahasiswa</h4>
                <a class="btn btn-primary btn-sm mb-2" href="create.php">Tambah
                    Mahasiswa</a>
                <!-- show alert -->
                <?php
                if (isset($_SESSION['flash_message']) && isset($_GET['msg'])) {
                    if ($_GET['msg'] == '1') {
                        alert($_SESSION['flash_message'], 1);
                    } else {
                        alert($_SESSION['flash_message'], 0);
                    }
                }
                ?>
                <table class="table table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>NAMA</th>
                            <th>JURUSAN</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (!empty($result) && is_array($result)) { // Check if $result is not empty and is an array
                            foreach ($result as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row->nim) ?></td>
                                    <td><?= htmlspecialchars($row->nama) ?></td>
                                    <td><?= htmlspecialchars($row->jurusan) ?></td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="edit.php?id=<?= htmlspecialchars($row->id) ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="function/Mahasiswa.php?action=delete&&id=<?= htmlspecialchars($row->id) ?>" onclick="return confirm('Anda yakin ingin menghapus Data <?= htmlspecialchars($row->nama) ?>?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">No data available</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>