<?php
include_once "db.php";
if (User::inSession()) {
    header("Location : dashboard.php");
}
$username = $email = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = Validator::isFilled($_POST["username"])->unwrapOr("");
    $email = Validator::isFilled($_POST["email"])->unwrapOr("");
    User::register(
        $username,
        $_POST["password"],
        $email,
        $_POST["confirm_password"],
        $nameErr,
        $passwordErr,
        $emailErr,
        $confirmPasswordErr
    );
    if (array_key_exists('login', $_POST)) {
        header("Location: login.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar sekarang!</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>




    <body class="bg-light">
        <div class="d-flex ">
            <div class="card shadow w-50">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="fw-bold">Register</h3>
                </div>
                <div class="container">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="name">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo $username; ?>">
                            <span class="error"><?php echo $nameErr; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                            <span class="error"><?php echo $emailErr; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password">
                            <span class="error"><?php echo $passwordErr; ?></span>
                            <div class="password-requirements">
                                Password requirement:
                                <ul>

                                    <li>Contain at least 8 characters</li>
                                    <li>Contain a capital letter</li>
                                    <li>Contain a regular letter</li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password">
                            <span class="error"><?php echo $confirmPasswordErr; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success fw-bold" value="Register">
                            <input type="submit" name="login"
                                class="btn btn-primary fw-bold" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>