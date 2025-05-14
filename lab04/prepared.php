<?php
require_once 'db_connection.php';
try {
// prepare sql and bind parameters
$stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email)
VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
// insert a row
$firstname = "Sophie";
$lastname = "Randall";
$email = "sophie.randall@example.com";
$stmt->execute();
// insert another row
$firstname = "Abigail";
$lastname = "Wilkins";
$email = "abigail.wilkins@example.com";
$stmt->execute();
// insert another row
$firstname = "Alison";
$lastname = "Newman";
$email = "alison.newman@example.com";
$stmt->execute();
echo "New records created successfully";
} catch(PDOException $e) {
echo "Error: " . $e->getMessage();
}
$conn = null;
?>