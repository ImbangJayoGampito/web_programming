<?php
session_start();

if (isset($_SESSION["current_user"])) {
    $current_user = $_SESSION["current_user"];
} else {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('logout', $_POST)) {
        unset($_SESSION["current_user"]);
        header("Location: login.php");
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">



        <div class="form-group">
            <input type="submit" name="logout"
                class="button" value="Keluar" />
        </div>
    </form>
    <div>
        <h1>Selamat datang, <?php echo $current_user["name"] ?></h1>
        <p>Email: <?php echo $current_user["email"]?></p>
        <p>Password terenkripsi: <?php echo $current_user["password"]?></p>
        <p>Kamu mendaftar pada <?php echo $current_user["registration_time"]?></p>
    </div>

</body>

</html>