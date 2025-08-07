<?php
session_start();
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
