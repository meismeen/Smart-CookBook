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
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }

        if (!file_exists($file) || filesize($file) === 0) {
            $xml = new SimpleXMLElement('<users></users>');
        } else {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($file);
            if ($xml === false) {
                $xml = new SimpleXMLElement('<users></users>');
            }
        }

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #2575fc;
        }
        .btn-custom {
            background: #2575fc;
            color: white;
            font-weight: 600;
        }
        .btn-custom:hover {
            background: #1e5ed6;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h3 class="text-center mb-4">Create an Account</h3>
        <form method="post" action="register.php">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">Show</button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            field.type = field.type === "password" ? "text" : "password";
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
