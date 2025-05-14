<?php
require_once 'db_connection.php';
try {
    $stmt = $conn->prepare("SELECT * FROM MyGuests");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>My Guests</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $key => $guest) { ?>
                <tr>
                    <td><?= $guest['id'] ?></td>
                    <td><?= $guest['firstname'] ?></td>
                    <td><?= $guest['lastname'] ?></td>
                    <td><?= date_format(date_create($guest['reg_date']), 'D, d F Y H:i') ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>