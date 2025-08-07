<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = 'data/users.xml';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Load XML safely
    if (!file_exists($file) || filesize($file) === 0) {
        echo "<script>alert('No registered users found. Please register first.');</script>";
    } else {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($file);

        if ($xml === false) {
            echo "<script>alert('User database corrupted.');</script>";
        } else {
            $found = false;

            foreach ($xml->user as $user) {
                if ((string)$user->username === $username &&
                    password_verify($password, (string)$user->password)) {
                    $found = true;
                    $_SESSION['username'] = $username;
                    break;
                }
            }

            if ($found) {
                echo "<script>alert('Login successful! Redirecting...');</script>";
                echo "<script>setTimeout(() => window.location.href='dashboard.php', 1000);</script>";
                exit();
            } else {
                echo "<script>alert('Invalid username or password.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" method="post" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="button" onclick="togglePassword('password')">Show</button>

        <button type="submit">Login</button>
    </form>

    <script src="scripts/main.js"></script>
</body>
</html>
