<?php
$pageTitle = "Home";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $pageTitle ?> - Smart CookBook</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
    }
    footer {
      background-color: #17191cff; /* same as navbar */
      color: white;
      text-align: center;
      padding: 25px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Smart Cookbook</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main content -->
<main>
  <div class="p-5 mb-4 bg-body-tertiary rounded-3">
    <div class="container py-5">
      <h1 class="display-5 fw-bold">Your recipes, beautifully organized.</h1>
      <p class="col-lg-8 fs-5">
        Create, edit, remember, and share your favorite recipes. Start by logging in or signing up.
      </p>
      <a href="dashboard.php" class="btn btn-primary btn-lg me-2">Go to Dashboard</a>
      <a href="add_recipe.php" class="btn btn-outline-secondary btn-lg">Add a Recipe</a>
    </div>
  </div>
</main>

<section class="p-5 bg-light">
  <div class="container">
    <h2 class="fw-bold">Explore Popular Recipes</h2>
    <p>Browse the most loved recipes from our community.</p>
    <a href="cookbook.php" class="btn btn-success">View Recipes</a>
  </div>
</section>

<!-- Footer -->
<footer>
  &copy; <?= date('Y') ?> Smart CookBook
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>