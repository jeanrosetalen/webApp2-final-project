<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/Style_Home.css">
    <title>HomePage</title>
</head>
<body>
    <div class="posts">
        <h1>Browse Posts of your Preference</h1>
        <ul id="ul">
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
                $user_id = $_SESSION['user_id'];

                $query = "SELECT * FROM `posts` WHERE userId = :id";
                $statement = $pdo->prepare($query);
                $statement->execute([':id' => $user_id]);

                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    echo '<li><a href="PostPage.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                }

            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
        </ul>
    </div>
</body>
</html>