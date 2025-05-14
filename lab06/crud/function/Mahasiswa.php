<?php
include_once '../config/Config.php';
include_once '../config/Database.php';
include_once '../model/Mahasiswa.php';
$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'create') {
        $mahasiswa->nim = $_POST['nim'];
        $mahasiswa->nama = $_POST['nama'];
        $mahasiswa->jurusan = $_POST['jurusan'];
        $mahasiswa->create();
    } elseif ($action == 'delete') {
        $mahasiswa->id = $_GET['id'];
        $mahasiswa->delete();
    } elseif ($action == 'update') {
        $mahasiswa->id = $_POST['id'];
        $mahasiswa->nim = $_POST['nim'];
        $mahasiswa->nama = $_POST['nama'];
        $mahasiswa->jurusan = $_POST['jurusan'];
        $mahasiswa->update();
    }
} else {
    header("Location: ../index.php?msg=0");
}
