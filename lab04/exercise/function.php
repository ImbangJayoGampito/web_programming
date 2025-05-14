<?php
/**
* CREATE
*/
function createGuest($firstname, $lastname, $email)
{
global $connection;
$sql = "INSERT INTO myguests (firstname, lastname, email, reg_date)
VALUES (:firstname, :lastname, :email, NOW())";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
try {
$stmt->execute();
return "Data berhasil ditambahkan!";
} catch (PDOException $e) {
return "Gagal menambahkan data: " . $e->getMessage();
}
}
/**

* GET ALL DATA
*/
function getGuests()
{
global $connection;
$sql = "SELECT * FROM myguests";
$stmt = $connection->query($sql);
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/**
* GET DATA BY ID
*/
function getGuest($id)
{
global $connection;
$stmt = $connection->prepare("SELECT * FROM myguests WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
return $stmt->fetch(PDO::FETCH_ASSOC);
}
/**
* UPDATE
*/
function updateGuest($id, $firstname, $lastname, $email)
{
global $connection;
$sql = "UPDATE myguests
SET firstname = :firstname, lastname = :lastname, email = :email
WHERE id = :id";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':id', $id);
try {
$stmt->execute();
return "Data berhasil diupdate!";
} catch (PDOException $e) {
return "Gagal mengupdate data: " . $e->getMessage();
}
}
/**

* DELETE
*/
function deleteGuest($id)
{
global $connection;
$sql = "DELETE FROM myguests WHERE id = :id";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':id', $id);
try {
$stmt->execute();
return "Data berhasil dihapus!";
} catch (PDOException $e) {
return "Gagal menghapus data: " . $e->getMessage();
}
}