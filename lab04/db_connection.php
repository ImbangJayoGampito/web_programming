<?php
$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;
$dbname = "mrrpmeow";
try {
    $conn = new PDO(
        "mysql:host=$servername;port=$port;dbname=$dbname",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connected meow";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
