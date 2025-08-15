<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$username = $_SESSION['username'];
$cookbookPath = "data/cookbooks/{$username}.xml";

$xml = loadXML($cookbookPath);
if (!$xml) {
    die("Cookbook not found.");
}

$recipeId = $_GET['id'] ?? null;
if (!$recipeId) {
    die("Recipe ID not provided.");
}

// Find recipe
$target = null;
foreach ($xml->recipe as $recipe) {
    if ((string)$recipe['id'] === $recipeId) {
        $target = $recipe;
        break;
    }
}

if (!$target) {
    die("Recipe not found.");
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target->title = htmlspecialchars($_POST['title']);
    $target->ingredients = htmlspecialchars($_POST['ingredients']);
    $target->steps = htmlspecialchars($_POST['steps']);
    $target->tags = htmlspecialchars($_POST['tags']);

    saveXML($xml, $cookbookPath);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<!-- Page Content -->
<div class="container mt-5">
        <h2 class="mb-4 text-center">Edit Recipe</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($target->title) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ingredients (comma-separated)</label>
                <textarea name="ingredients" class="form-control" rows="3" required><?= htmlspecialchars($target->ingredients) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Steps</label>
                <textarea name="steps" class="form-control" rows="4" required><?= htmlspecialchars($target->steps) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tags</label>
                <input type="text" name="tags" class="form-control" value="<?= htmlspecialchars($target->tags) ?>">
            </div>

            <div class="d-flex justify-content-between">
                <a href="dashboard.php" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">Update Recipe</button>
            </div>
        </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>