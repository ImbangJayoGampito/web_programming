<?php
include_once "db.php";
$user = new User();
if (User::inSession()) {
    $user = User::userInSession()->unwrap();
} else {
    User::leadToHome();
    $user = null;
}


$passErr = $emailErr = $usernameErr = "";
$username = htmlspecialchars($user->username);
$email = htmlspecialchars($user->getEmail());
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $email = $_POST['email'];
    $oldPassword = $_POST['old_password'];
    $success = $user->updateProfile(
        $username,
        $oldPassword,
        $newPassword,
        $email,
        $usernameErr,
        $passErr,
        $emailErr
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <a href="dashboard.php" class="btn btn-danger fw-bold position-absolute">Return</a>
                <h3 class="text-center fw-bold">Edit Profile</h3>

            </div>
            <div class="container">

                <?php if ($success): ?>
                    <div class="alert alert-success text-center mt-2"><?= htmlspecialchars("Profile updated successfully!") ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $username  ?>" required>
                        <?php if (!$success): ?>
                            <span class="error"><?php echo $usernameErr; ?></span>
                        <?php endif; ?>

                    </div>
                    <div class="form-group">
                        <label for="password">Old Password:</label>
                        <input type="password" id="old_password" name="old_password">


                    </div>
                    <div class="form-group">
                        <label for="confirm_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password">
                        <div class="password-requirements">
                            Password requirement:
                            <ul>

                                <li>Contain at least 8 characters</li>
                                <li>Contain a capital letter</li>
                                <li>Contain a regular letter</li>
                            </ul>
                        </div>
                        <?php if (!$success): ?>
                            <span class="error"><?php echo $passErr; ?></span>
                        <?php endif; ?>

                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                        <?php if (!$success): ?>
                            <span class="error"><?php echo $emailErr; ?></span>
                        <?php endif; ?>

                    </div>
                    <div class="text-center mb-2">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>