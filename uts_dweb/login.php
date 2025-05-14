<?php
include_once "helper.php";
include_once "db.php";
$userOrEmail = $password  = "";
$userOrEmailErr =  $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userOrEmail = Validator::isFilled($_POST["username"])->unwrapOr("");
    $password = Validator::isFilled($_POST["password"])->unwrapOr("");
    User::login($userOrEmail, $password, $userOrEmailErr, $passwordErr);
}

if (User::inSession()) {
    header("Location: dashboard.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="d-flex ">
        <div class="card shadow w-50">
            <div class="card-header bg-success text-white text-center">
                <h3 class="fw-bold">Login</h3>
            </div>
            <div class="container p-4">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group mb-3">
                        <label for="username">Username/Email:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $userOrEmail; ?>">
                        <span class="text-danger"><?php echo $userOrEmailErr; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control">
                        <span class="text-danger"><?php echo $passwordErr; ?></span>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" name="login" class="btn btn-success fw-bold" value="Login">
                        <a href="register.php" class="btn btn-primary fw-bold">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>