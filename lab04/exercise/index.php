<?php
include 'db.php';
include 'function.php';
// Fungsi untuk memproses input data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        echo createGuest($firstname, $lastname, $email);
    }
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        echo updateGuest($id, $firstname, $lastname, $email);
    }
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        echo deleteGuest($id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Formulir untuk menambahkan data -->
    <h2>Tambah Tamu</h2>
    <form method="POST">
        <input type="text" name="firstname" placeholder="First Name" required><br>
        <input type="text" name="lastname" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <button type="submit" name="create">Tambah</button>
    </form>
    <!-- Menampilkan semua data -->
    <h2>Daftar Tamu</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Reg Date</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $guests = getGuests();
        ?>
        <tbody>
            <?php foreach ($guests as $guest) { ?>
                <tr>
                    <td><?= $guest['id'] ?></td>
                    <td><?= $guest['firstname'] ?></td>
                    <td><?= $guest['lastname'] ?></td>
                    <td><?= $guest['email'] ?></td>
                    <td><?= date_format(date_create($guest['reg_date']), 'D, d F Y H:i') ?></td>
                    <td>
                        <a href="update.php?id=<?= $guest['id'] ?>" typy="button" class="">Edit</a>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='<?= $guest['id'] ?>'>
                            <button type='submit' name='delete' onclick='return confirm("Are you sure?")'>Delete</button>
                        </form>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</body>

</html>