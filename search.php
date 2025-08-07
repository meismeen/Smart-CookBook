<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$searchTerm = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$results = [];

if ($searchTerm !== '') {
    $cookbookDir = 'data/cookbooks/';
    $files = scandir($cookbookDir);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'xml') {
            $xml = loadXML($cookbookDir . $file);
            if ($xml) {
                foreach ($xml->recipe as $recipe) {
                    $title = strtolower((string) $recipe->title);
                    $tags = strtolower((string) $recipe->tags);

                    if (strpos($title, $searchTerm) !== false || strpos($tags, $searchTerm) !== false) {
                        $results[] = [
                            'title' => (string) $recipe->title,
                            'id' => (string) $recipe['id'],
                            'owner' => basename($file, '.xml'),
                            'tags' => (string) $recipe->tags,
                        ];
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Recipes</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Search Recipes</h1>

    <form method="GET">
        <input type="text" name="q" placeholder="Enter title or tag" required value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($searchTerm !== ''): ?>
        <h2>Results for: <?= htmlspecialchars($searchTerm) ?></h2>

        <?php if (!empty($results)): ?>
            <ul>
            <?php foreach ($results as $r): ?>
                <li>
                    <strong><?= htmlspecialchars($r['title']) ?></strong> 
                    (by <?= htmlspecialchars($r['owner']) ?>)
                    — Tags: <?= htmlspecialchars($r['tags']) ?>
                    [<a href="view_recipe.php?id=<?= urlencode($r['id']) ?>">View</a>]
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No matching recipes found.</p>
        <?php endif; ?>
    <?php endif; ?>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>