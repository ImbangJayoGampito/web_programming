<?php
session_start();
include_once 'crud/config/Database.php';
class Mahasiswa
{
    private $conn;
    private $table = 'mahasiswa';

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public $id;
    public $nim;
    public $nama;
    public $jurusan;
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET nim=?, nama=?, jurusan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $this->nim, $this->nama, $this->jurusan);
        if ($stmt->execute()) {
            header("Location: /web_programming/lab06/index.php?msg=1");
            $_SESSION['flash_message'] = "Data Mahasiswa Berhasil Ditambahkan";
        } else {
            header("Location: /web_programming/lab06/index.php?msg=0");
            $_SESSION['flash_message'] = "Data Mahasiswa Gagal Ditambahkan";
        }
        return false;
    }
    public function read($id = "")
    {
        if ($id == "") {
            $query = "SELECT 
            * FROM " .
                $this->table;
            $stmt = $this->conn->prepare($query);
        } else {
            $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {

            return null;
        }
    }
    public function update()
    {
        $query = "UPDATE " . $this->table . " SET nim=?, nama=?, jurusan=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $this->nim, $this->nama, $this->jurusan, $this->id);
        if ($stmt->execute()) {
            header("Location: /web_programming/lab06/index.php?msg=1");
            $_SESSION['flash_message'] = "Data Mahasiswa Berhasil Diubah";
        } else {
            header("Location: /web_programming/lab06/index.php?msg=0");
            $_SESSION['flash_message'] = "Data Mahasiswa Gagal Diubah";
        }
        return false;
    }
    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        if ($stmt->execute()) {
            header("Location: /web_programming/lab06/index.php?msg=1");
            $_SESSION['flash_message'] = "Data Mahasiswa Berhasil Dihapus";
        } else {
            header("Location: /web_programming/lab06/index.php?msg=0");
            $_SESSION['flash_message'] = "Data Mahasiswa Gagal Dihapus";
        }
        return false;
    }
}
