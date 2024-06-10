<?php

require 'Config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit;
}

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM `posts` WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute([':id' => $id]);

            $post = $statement->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                $title = '<h2>' . $post['title'] . '</h2>';
                $body = '<p>' . $post['body'] . '</p>';
            } else {
                echo "No post found with ID $id!";
            }
        } else {
            echo "No post ID provided!";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/Style_Post.css">
    <title>Post Page</title>
</head>

<body>
    <div class="background-area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="container">
        <div class="post-container">
            <h1>Take your Time To Read This</h1>
            <?= $title; ?>
            <hr>
            <h5>Title</h5>
            <h4>Content:</h4>
            <?= $body; ?>
        </div>
    </div>
</body>

</html>   