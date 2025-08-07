<?php
session_start();
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
