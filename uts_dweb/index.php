<?php
include_once "db.php";
$user = null;
$all_posts = array_map(function ($post) {
    return $post instanceof Post ? $post : new Post($post);
}, Post::getSorted("uploaded_at", "DESC")->unwrapOr([]));

if (User::inSession()) {
    $user = User::userInSession()->unwrap();
}
$latestSelected = $_SESSION['latestSelected'] ?? false;
$post_selected = 5;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (array_key_exists('changepost', $_POST)) {

        $latestSelected = !$latestSelected;
        if ($latestSelected) {
            $post_selected = 5;
        } else {
            $post_selected =  count($all_posts);
        }
        $_SESSION['latestSelected'] = $latestSelected;
        $all_posts = array_map(function ($post) {
            return $post instanceof Post ? $post : new Post($post);
        }, Post::getSorted("uploaded_at", "DESC")->unwrapOr([]));
    }
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

<body class="bg-secondary opacity-100">
    <div class="container rounded bg-success pb-2">

        <?php if (User::inSession()): ?>
            <h1 class="text-center fw-bold">Welcome back to Vertisium</h1>
            <p class="text-center">Oh hello there, <strong><?= htmlspecialchars($user->username) ?></strong>. It's good to see you back! Why don't you grab a coffee and take a look at your profile? Or even make another post?</p>
            <div class="text-center">
                <a href="dashboard.php" class="btn btn-info mx-auto fw-bolder" role="button">Profile</a>
                <a href="create_post.php" class="btn btn-info mx-auto fw-bolder" role="button">Create Post</a>
                <a href="search.php" class="btn btn-info mx-auto fw-bolder" role="button">Search</a>
            </div>



        <?php else: ?>
            <h1 class="text-center fw-bold">Welcome to Vertisium</h1>
            <p class="text-center">Vertisium is a forum dedicated to discussing ideas, sharing knowledge, and connecting with people who share your interests. Join us today!</p>
            <div class="text-center">
                <a href="register.php" class="btn btn-info mx-auto fw-bolder" role="button">Register</a>
                <a href="login.php" class="btn btn-info mx-auto fw-bolder" role="button">Login</a>
            </div>
        <?php endif; ?>


    </div>
    <div class="container rounded-3 pb-2 mt-2 bg-secondary opacity-25">

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center bg-success rounded-3 px-3 py-2">
                <?php if ($latestSelected == true): ?>
                    <h3 class="text-center fw-bold">Latest Posts</h3>
                <?php else: ?>
                    <h3 class="text-center fw-bold">All Posts</h3>
                <?php endif; ?>

                <?php if (User::inSession()): ?>
                    <form method="POST" action="">

                        <input type="submit" name="changepost" class="btn btn-info btn-sm fw-bold" value="<?= $latestSelected ? "Show All Posts" : "Show Latest Posts" ?>">
                    </form>
                <?php endif; ?>
            </div>

            <ul class="list-group">
                <?php foreach (array_slice($all_posts, 0, $post_selected) as $post): ?>
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
                        <small>Uploaded at: <?= htmlspecialchars($post->uploaded_at) . " GMT by " . htmlspecialchars($username) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>