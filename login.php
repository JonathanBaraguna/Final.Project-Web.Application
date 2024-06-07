<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check users table
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: user_dashboard.php");
            exit();
        }
    }

    // Check admins table
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'admin';
            header("Location: admin_dashboard.php");
            exit();
        }
    }

    echo "Invalid username or password";
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="iconn/books.png" type="image/x-icon">
    <link rel="stylesheet" href="code-css/login.css">
</head>
<body>


<div class="main">
    <div class="main2">
    <h1>BookVerse</h1>
    </div>

    <div class="login">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>
    </div>
    <div class="sign-up">
        <button type="button" onclick="location.href='signUp.php'">Sign Up</button>
    </div>
</div>


</body>
</html>