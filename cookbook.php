<?php
session_start();
$username = $_SESSION['username'] ?? null;

if (!$username) {
    header("Location: login.php");
    exit;
}

$recipes = [];
$xmlFile = "data/cookbooks/$username.xml";

// Load user's cookbook XML if exists
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);

    foreach ($xml->recipe as $r) {
        $recipes[] = [
            'title' => (string)$r->title,
            'description' => (string)$r->description,
            'tags' => (string)$r->tags,
        ];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($username); ?>'s Cookbook</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($username); ?>'s Cookbook</h2>

    <input type="text" id="recipeSearch" placeholder="Search recipes..." onkeyup="filterRecipes()">

    <div id="recipeList">
        <?php if (empty($recipes)): ?>
            <p>No recipes found.</p>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-item">
                    <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                    <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                    <small>Tags: <?php echo htmlspecialchars($recipe['tags']); ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="scripts/main.js"></script>
</body>
</html>
