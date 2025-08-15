<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = 'data/users.xml';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!file_exists($file) || filesize($file) === 0) {
        echo "<script>alert('No users registered yet.');</script>";
    } else {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($file);
        if ($xml === false) {
            echo "<script>alert('User database is corrupted.');</script>";
        } else {
            $found = false;
            foreach ($xml->user as $user) {
                if ((string)$user->username === $username && password_verify($password, (string)$user->password)) {
                    $_SESSION['username'] = $username;
                    header("Location: dashboard.php");
                    exit();
                }
            }
            if (!$found) {
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
    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
            width: 350px;
        }
        .form-container h2 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #66a6ff;
            color: white;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #558de8;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>
    <form method="post" action="login.php">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

</body>
</html>