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
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <a href="add_recipe.php">➕ Add New Recipe</a>
    <h2>Your Recipes:</h2>

    <?php if ($recipes && count($recipes->recipe) > 0): ?>
        <ul>
        <?php foreach ($recipes->recipe as $recipe): ?>
            <li>
                <strong><?= htmlspecialchars($recipe->title) ?></strong>
                [<a href="view_recipe.php?id=<?= urlencode($recipe['id']) ?>">View</a> |
                 <a href="edit_recipe.php?id=<?= urlencode($recipe['id']) ?>">Edit</a>]
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No recipes found. Add one now!</p>
    <?php endif; ?>
</body>
</html>