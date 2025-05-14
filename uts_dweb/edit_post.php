<?php
include_once "db.php";
$user = new User();
if (User::inSession()) {
    $user = User::userInSession()->unwrap();
} else {
    User::leadToHome();
    $user = null;
}
$uploaded = false;
$post_id = $_GET["post_id"] ?? null;
$post = Post::find("id", $post_id)->unwrapOr(null);
if ($post == null) {
    header("Location: dashboard.php");
    exit;
}
$title = $post->title ?? "";
$description = $post->description ?? "";
function edit(&$errorMsg, User $user, &$title, &$description, &$uploaded, $post)
{
    $title = $_POST["title"];
    $description = $_POST["message"];
    $uploaded = true;

    if (!empty($errorMsg)) {
        return;
    }
    $post->title = $title;

    $post->description = $description;

    if ($post->save()) {
        $title = $description = "";
        header("Location: dashboard.php");
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    edit($errorMsg, $user, $title, $description, $uploaded, $post);
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
                <h3 class="text-center fw-bold">Edit Post</h3>
            </div>
            <div class="card-body">

                <?php if ($uploaded): ?>
                    <?php if (empty($errorMsg)): ?>
                        <div class="alert alert-success text-center mt-2">Post edited successfully!</div>
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

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Edit Post</button>

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