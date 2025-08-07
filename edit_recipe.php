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
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Edit Recipe: <?= htmlspecialchars($target->title) ?></h1>

    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($target->title) ?>" required><br><br>

        <label>Ingredients (comma-separated):</label><br>
        <textarea name="ingredients" required><?= htmlspecialchars($target->ingredients) ?></textarea><br><br>

        <label>Steps:</label><br>
        <textarea name="steps" required><?= htmlspecialchars($target->steps) ?></textarea><br><br>

        <label>Tags:</label><br>
        <input type="text" name="tags" value="<?= htmlspecialchars($target->tags) ?>"><br><br>

        <button type="submit">Update Recipe</button>
    </form>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>