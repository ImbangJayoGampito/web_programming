<?php

class DB
{

    private PDO $conn;
    private static $obj;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbName = 'pemrograman_web';
    private final function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4", $this->user, $this->pass);
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
    public function getConnection()
    {
        return $this->conn;
    }
    public static function getInstance()
    {
        if (!isset(self::$obj)) {
            self::$obj = new DB();
        }
        return self::$obj;
    }
}




