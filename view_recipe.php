<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$username = $_SESSION['username'];
$recipeId = $_GET['id'] ?? null;
if (!$recipeId) die("No recipe ID provided.");

$cookbookPath = "data/cookbooks/{$username}.xml";
$commentsPath = "data/comments/{$recipeId}_comments.xml";

// Load recipe
$xml = loadXML($cookbookPath);
if (!$xml) die("Cookbook not found.");

$target = null;
foreach ($xml->recipe as $recipe) {
    if ((string)$recipe['id'] === $recipeId) {
        $target = $recipe;
        break;
    }
}
if (!$target) die("Recipe not found.");

// Load or initialize comments XML
if (file_exists($commentsPath)) {
    $comments = loadXML($commentsPath);
} else {
    $comments = new SimpleXMLElement("<comments></comments>");
}

// Handle comment form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $comments->addChild("comment");
    $comment->addChild("user", htmlspecialchars($username));
    $comment->addChild("text", htmlspecialchars($_POST['text']));
    $comment->addChild("rating", intval($_POST['rating']));
    saveXML($comments, $commentsPath);
    header("Location: view_recipe.php?id=" . urlencode($recipeId));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($target->title) ?></title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1><?= htmlspecialchars($target->title) ?></h1>
    <p><strong>Ingredients:</strong><br><?= nl2br(htmlspecialchars($target->ingredients)) ?></p>
    <p><strong>Steps:</strong><br><?= nl2br(htmlspecialchars($target->steps)) ?></p>
    <p><strong>Tags:</strong> <?= htmlspecialchars($target->tags) ?></p>

    <hr>

    <h2>Leave a Comment / Rating</h2>
    <form method="POST">
        <label>Comment:</label><br>
        <textarea name="text" required></textarea><br><br>

        <label>Rating (1-5):</label><br>
        <input type="number" name="rating" min="1" max="5" required><br><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Comments:</h2>
    <?php if (count($comments->comment) > 0): ?>
        <ul>
            <?php foreach ($comments->comment as $c): ?>
                <li>
                    <strong><?= htmlspecialchars($c->user) ?>:</strong>
                    <?= htmlspecialchars($c->text) ?> (⭐ <?= htmlspecialchars($c->rating) ?>/5)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>