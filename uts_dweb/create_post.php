<?php
include "db.php";

$errorMsg = $title =  $description = "";


$user = new User();
if (User::inSession()) {
    $user = User::userInSession()->unwrap();
} else {
    User::leadToHome();
    $user = null;
}
$uploaded = false;
function createPost(&$errorMsg, User $user, &$title, &$description, &$uploaded)
{
    $title = $_POST["title"];
    $description = $_POST["message"];
    $files = $_FILES['files'];
    $file_count = count($files['name']) || 0;
    $uploaded = true;
    $files = [];

    if (isset($_FILES['files']) && $_FILES['files']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        for ($i = 0; $i < $file_count; $i++) {
            $fileName = $_FILES['files']['name'][$i];
            $tmp = $_FILES['files']['tmp_name'][$i];
            $type = $_FILES['files']['type'][$i];
            $error = $_FILES['files']['error'][$i];
            $size = $_FILES['files']['size'][$i];
            $res = File::createFile($fileName, $type, $error, $size, $tmp, $user);

            if ($res->isOk) {
                $files[$i] = $res->unwrap();
            } else {
                $errorMsg = $res->getError();
                break;
            }
        }
    }


    if (!empty($errorMsg)) {
        return;
    }
    $toPost = new Post();
    $toPost->makePost($title, $description);
    $toPost->uploadPost($files, $errorMsg, $user);
    if (empty($errorMsg)) {
        $title = $description = "";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    createPost($errorMsg, $user, $title, $description, $uploaded);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <a href="dashboard.php" class="btn btn-danger fw-bold position-absolute">Return</a>
                <h3 class="text-center fw-bold">Create Post</h3>
            </div>
            <div class="card-body">

                <?php if ($uploaded): ?>
                    <?php if (empty($errorMsg)): ?>
                        <div class="alert alert-success text-center mt-2">Post uploaded successfully!</div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center mt-2"><?= htmlspecialchars($errorMsg) ?></div>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Post Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Post Content</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?= htmlspecialchars($description ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">Upload Files</label>
                        <input type="file" class="form-control" id="files" name="files[]" multiple>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Upload Post</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>