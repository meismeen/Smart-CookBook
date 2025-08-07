<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = 'data/users.xml';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Ensure data folder exists
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }

        // If file does not exist or is empty/corrupt, create a new XML object
        if (!file_exists($file) || filesize($file) === 0) {
            $xml = new SimpleXMLElement('<users></users>');
        } else {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($file);
            if ($xml === false) {
                // Failed to load due to invalid XML → recreate
                $xml = new SimpleXMLElement('<users></users>');
            }
        }

        // Check for duplicate username
        $exists = false;
        foreach ($xml->user as $user) {
            if ((string)$user->username === $username) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            echo "<script>alert('Username already exists.');</script>";
        } else {
            $newUser = $xml->addChild('user');
            $newUser->addChild('username', $username);
            $newUser->addChild('password', password_hash($password, PASSWORD_DEFAULT));
            $xml->asXML($file);

            echo "<script>alert('Registration successful! Redirecting to login...');</script>";
            echo "<script>setTimeout(() => window.location.href='login.php', 1000);</script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h2>Register</h2>
    <form id="registerForm" method="post" action="register.php">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="button" onclick="togglePassword('password')">Show</button>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Register</button>
    </form>

    <script src="scripts/main.js"></script>
</body>
</html>
