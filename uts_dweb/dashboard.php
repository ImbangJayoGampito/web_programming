<?php
include_once "db.php";
$user = new User();
if (User::inSession()) {
    $user = User::userInSession()->unwrap();
} else {
    User::leadToHome();
    $user = null;
}
$posts = Post::find_all("user_id", $user->id)->unwrapOr([]);
$posts = array_map(function ($post) {
    return $post instanceof Post ? $post : new Post($post);
}, $posts);
$latestSelected = $_SESSION['latestSelected'] ?? true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (array_key_exists('logout', $_POST)) {
        $user->logout();
    }
    if (array_key_exists('delete', $_POST)) {
        $user->delete("id", $user->id);
        $user->logout();
    }
    if (array_key_exists('changepost', $_POST)) {
        $latestSelected = !$latestSelected;
        $_SESSION['latestSelected'] = $latestSelected;
    }
    if (array_key_exists('delete_post', $_POST)) {

        $post_id = $_POST['post_id'];
        echo $post_id;
        $post = Post::find("id", $post_id)->unwrapOr(null);
        if ($post) {
            $post->removePost();
            $posts = Post::find_all("user_id", $user->id)->unwrapOr([]);
            $posts = array_map(function ($post) {
                return $post instanceof Post ? $post : new Post($post);
            }, $posts);
        }
    }
    if (array_key_exists('edit_post', $_POST)) {
        $post_id = $_POST['post_id'];
        $_SESSION['post_id_temp'] = $post_id;
        header("Location: edit_post.php?post_id=" . $post_id);
    }
}
$user_list = User::get_all()->unwrapOr([]);
?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body class="bg-secondary opacity-100">

    <div class="container bg-white rounded-3 pb-2 mt-2">
        <div class="jumbotron">
            <h1 class="display-4"><?= "Hello, " . htmlspecialchars($user->username) . " !" ?></h1>
            <p class="lead">This is your simple sweet wonderful profile</p>

            <div class="text-center">
                <a href="index.php" class="btn btn-success mx-auto fw-bolder" role="button">Homepage</a>
            </div>
            <hr class="my-4">
            <p>Consider exploring more contents provided in this site!</p>
            <p class="lead">
            <div class="text-center">
                <a href="create_post.php" class="btn btn-success mx-auto fw-bolder" role="button">Create Post</a>
                <a href="edit_profile.php" class="btn btn-success mx-auto fw-bolder" role="button">Edit Profile</a>
            </div>
            </p>
            <hr class="my-4">
            <p>Log out from this account!</p>
            <form action="" method="post">
                <div class="text-center">
                    <button type="submit" name="logout" class="btn btn-danger fw-bolder mx-auto ">Log out</button>
                </div>
            </form>
            <hr class="my-4">
            <p>Delete your account! <strong>This can not be undone!</strong></p>
            <form action="" method="post">
                <div class="text-center">
                    <button type="submit" name="delete" class="btn btn-danger fw-bolder mx-auto ">DELETE ACCOUNT</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container rounded-3 pb-2 mt-2 bg-secondary opacity-25">

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center bg-success rounded-3 px-3 py-2">
                <?php if ($latestSelected == true): ?>
                    <h3 class="text-center fw-bold">All users</h3>
                <?php else: ?>
                    <h3 class="text-center fw-bold">Your posts</h3>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="submit" name="changepost" class="btn btn-info btn-sm fw-bold" value="<?= $latestSelected ? "Show your posts" : "Show all users" ?>">

            </div>
            <?php if ($latestSelected == true): ?>
                <ul class="list-group">
                    <?php foreach ($user_list as $selected_user): ?>
                        <li class="list-group-item">
                            <h5 class="">Username: <?= htmlspecialchars($selected_user->username) ?></h5>
                            <p>Id: <?= htmlspecialchars($selected_user->id) ?></p>

                            <small>Created at: <?= htmlspecialchars($selected_user->created_at) . " GMT" ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach (array_slice($posts, 0) as $post): ?>
                        <li class="list-group-item">
                            <h5 class="fw-bold"><?= htmlspecialchars($post->title) ?></h5>
                            <p><?= htmlspecialchars($post->description) ?></p>
                            <?php
                            $user = User::find("id", $post->user_id)->unwrapOr(null);
                            $username = null;
                            if ($user) {
                                $username = htmlspecialchars($user->username);
                            } else {
                                $username = "Unknown / Deleted User";
                            }
                            $files = File::find_all("item_id", $post->id)->unwrapOr([]);
                            if (count($files) > 0) {
                                echo "<h6>Files:</h6>";
                                foreach ($files as $file) {
                                    echo "<a href='" . htmlspecialchars($file->filepath) . "' class='btn btn-primary' download>" . htmlspecialchars($file->filename) . "</a>";
                                }
                                echo "<br>";
                            }
                            ?>
                            <div class="d-flex  flex-row align-items-center justify-content-between">
                                <form method="POST" action="edit_post.php">

                                    <input type="hidden" name="post_id" value=<?= htmlspecialchars($post->id) ?>>
                                    <button type="submit" class="btn btn-warning" name="edit_post">Edit</button>
                                </form>
                                <form method="POST" action="dashboard.php">

                                    <input type="hidden" name="post_id" value=<?= htmlspecialchars($post->id) ?>>
                                    <button type="submit" class="btn btn-danger" name="delete_post">Delete</button>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>


        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>