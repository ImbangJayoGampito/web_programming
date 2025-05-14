<?php
require_once 'db_connection.php';
try {
    // begin the transaction
    $conn->beginTransaction();
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Mary', 'Moe', 'mary@example.com')");
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Julie', 'Dooley', 'julie@example.com')");
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Kane', 'Que', 'kane@example.com')");
    // commit the transaction
    $conn->commit();
    echo "New records created successfully";
} catch (PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn = null;
