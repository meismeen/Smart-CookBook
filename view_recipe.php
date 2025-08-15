<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$loggedInUser = $_SESSION['username'];
// Accept owner from GET, otherwise default to logged-in user
$owner = isset($_GET['user']) && $_GET['user'] !== '' ? $_GET['user'] : $loggedInUser;

$recipeId = $_GET['id'] ?? null;
if (!$recipeId) die("No recipe ID provided.");

$cookbookPath = "data/cookbooks/{$owner}.xml";
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

// Handle comment form (only allow logged-in users to comment)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($loggedInUser)) {
    $comment = $comments->addChild("comment");
    $comment->addChild("user", htmlspecialchars($loggedInUser));
    $comment->addChild("text", htmlspecialchars($_POST['text']));
    $comment->addChild("rating", intval($_POST['rating']));
    saveXML($comments, $commentsPath);

    // Redirect back to the same view (preserve owner)
    header("Location: view_recipe.php?user=" . urlencode($owner) . "&id=" . urlencode($recipeId));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($target->title) ?> — <?= htmlspecialchars($owner) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="mb-3">
        <a href="cookbook.php?user=<?= urlencode($owner) ?>" class="btn btn-sm btn-outline-secondary">← Back to <?php echo htmlspecialchars($owner); ?>'s Cookbook</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title"><?= htmlspecialchars($target->title) ?></h1>
            <p class="text-muted mb-1">By: <strong><?php echo htmlspecialchars($owner); ?></strong></p>
            <hr>
            <p><strong>Ingredients:</strong><br><?= nl2br(htmlspecialchars($target->ingredients)) ?></p>
            <p><strong>Steps:</strong><br><?= nl2br(htmlspecialchars($target->steps)) ?></p>
            <p><strong>Tags:</strong> <?= htmlspecialchars($target->tags) ?></p>
        </div>
    </div>

    <div class="row gx-4 gy-4">
        <div class="col-lg-6">
            <div class="card p-3">
                <h5 class="mb-3">Leave a Comment / Rating</h5>
                <?php if (!empty($loggedInUser)): ?>
                <form method="POST">
                    <div class="mb-3">
                        <textarea name="text" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Rating</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" required>
                    </div>
                    <button class="btn btn-success" type="submit">Submit</button>
                </form>
                <?php else: ?>
                    <p class="text-muted">Please <a href="login.php">log in</a> to comment.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6">
            <h5>Comments</h5>
            <?php if (count($comments->comment) > 0): ?>
                <?php foreach ($comments->comment as $c): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <strong><?= htmlspecialchars($c->user) ?></strong>
                            <span class="text-muted"> — ⭐ <?= htmlspecialchars($c->rating) ?>/5</span>
                            <p class="mb-0"><?= htmlspecialchars($c->text) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-secondary">No comments yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
