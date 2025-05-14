<?php
session_start();
include_once 'Model.php';
class Mahasiswa extends Model
{
    private $conn;
    protected static string $table = 'mahasiswa';


    public $id;
    public $nim;
    public $nama;
    public $jurusan;
    public function create()
    {

        if ($this->save()) {
            $_SESSION['flash_message'] = "Data berhasil disimpan!";
            header("Location: " . BASE_URL . "index.php?msg=1");
        } else {
            $_SESSION['flash_message'] = "Data gagal disimpan!";
            header("Location: " . BASE_URL . "index.php?msg=0");
        }
        return false;
    }
    public function read($id = "")
    {

        $res = null;
        if ($id == "") {
            $res = $this->get_all();
        } else {
            $res = $this->find("id", $this->id);
        }
        return $res;
    }
    public function update()
    {

        if ($this->save()) {
            $_SESSION['flash_message'] = "Data berhasil diupdate!";
            header("Location: " . BASE_URL . "index.php?msg=1");
        } else {
            $_SESSION['flash_message'] = "Data gagal diupdate!";
            header("Location: " . BASE_URL . "index.php?msg=0");
        }
        return false;
    }
    public function delete()
    {
        if ($this->deleteAt('id', $this->id)) {
            $_SESSION['flash_message'] = "Data berhasil dihapus!";
            header("Location: " . BASE_URL . "index.php?msg=1");
        } else {
            $_SESSION['flash_message'] = "Data gagal dihapus!";
            header("Location: " . BASE_URL . "index.php?msg=0");
        }
        return false;
    }
}
