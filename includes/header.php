<?php
// Start session early so navbar can show login state
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Optional: allow pages to set $pageTitle before including this file
$title = isset($pageTitle) ? $pageTitle : 'Smart CookBook';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>

  <!-- Bootstrap CSS + JS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Your custom styles -->
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="index.php">Smart CookBook</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
          <?php if (!empty($_SESSION['username'])): ?>
            <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="add_recipe.php">Add Recipe</a></li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
          <?php if (!empty($_SESSION['username'])): ?>
            <li class="nav-item">
              <span class="navbar-text me-3">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
            </li>
            <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item me-2"><a class="btn btn-outline-light btn-sm" href="login.php">Login</a></li>
            <li class="nav-item"><a class="btn btn-warning btn-sm" href="register.php">Sign Up</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page content starts -->
  <main class="container py-4">