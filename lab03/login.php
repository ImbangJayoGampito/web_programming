<?php
if (isset($_SESSION["current_user"])) {
    echo "meowwwww";
    header("Location: dashboard.php");
} 
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();
// Inisialisasi variabel
$emailErr = $passwordErr = "";
$name = $email = $password = $confirmPassword = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    logIn($_POST["email"], $_POST["password"], $emailErr, $passwordErr);
    if (array_key_exists('registration', $_POST)) {
        header("Location: registration.php");
    }
}
function logIn($email, $password, &$emailErr, &$passwordErr): bool
{



    $password = sanitizeInput($password);
    if (empty($email)) {
        $emailErr = "Email harus diisi!";
        return false;
    }

    if (empty($password)) {
        $passwordErr = "Password harus diisi!";
        return false;
    }
    $users = $_SESSION["registered_user"];
    $user_got = array();
    foreach ($users as $user) {

        if ($user["email"] == $email) {
            echo "found email!";
            $user_got = $user;
        }
    }
    if (count($user_got) === 0) {
        $emailErr = "User tidak terdaftar!";
        return false;
    }
    if (!password_verify($password, $user_got["password"])) {
        $passwordErr = "Password tidak cocok!";
        return false;
    }
    $_SESSION["current_user"] = $user_got;
    header("Location: dashboard.php");
    return true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;

            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .password-requirements {
            font-size: 0.8em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <h1>Form Login</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" value="Login">
            <input type="submit" name="registration"
                class="button" value="Daftar dulu" />
        </div>
    </form>

</body>

</html>