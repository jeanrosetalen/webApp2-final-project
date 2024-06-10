<?php

require 'Config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
              if ('jean1623' === $password) {
                  $_SESSION['user_id'] = $user['id'];
                  $_SESSION['username'] = $user['username'];

                  header("Location: HomePage.php");
                  exit;
              } else {
                  echo "Invalid Password";
              }
          } else {
              echo "User not found!";
          }
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
    <link rel="stylesheet" href="stylesheets/Style_Login.css">
    <title>Login Page</title>
</head>
<body>
    <canvas id="test"></canvas>
    <div class="Login_container">
        <h1>Welcome to our School Database</h1>
        <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" id="username" name= "username" placeholder="Enter username" required>
            <input type="password" id="password" name= "password" placeholder="Enter password" required>
            <button id="Login"><span>Login</span></button>
        </form>
    </div>

</body>
<script src = 'bgm/Login_bg.js'></script>
</html>