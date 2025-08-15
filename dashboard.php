<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin(); // Make sure user is logged in

$username = $_SESSION['username'];
$cookbookPath = "data/cookbooks/{$username}.xml";
$recipes = loadXML($cookbookPath);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $username ?>'s Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Smart Cookbook</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Welcome Section -->
<div class="container my-4">
    <div class="p-4 bg-white rounded shadow-sm text-center">
        <h1 class="fw-bold text-primary">Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <p class="text-muted">Manage your recipes with ease.</p>
        <a href="add_recipe.php" class="btn btn-success btn-lg mt-3">
            ➕ Add New Recipe
        </a>
    </div>
</div>

<!-- Recipes Section -->
<div class="container mb-5">
    <h2 class="fw-bold mb-4">Your Recipes</h2>
    <div class="row g-4">
        <?php if ($recipes && count($recipes->recipe) > 0): ?>
            <?php foreach ($recipes->recipe as $recipe): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($recipe->title) ?></h5>
                            <p class="card-text text-muted">A tasty recipe you’ve added to your cookbook.</p>
                            <a href="view_recipe.php?id=<?= urlencode($recipe['id']) ?>" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="edit_recipe.php?id=<?= urlencode($recipe['id']) ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">No recipes found. Add one now!</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>