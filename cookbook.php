<?php
session_start();
$loggedInUser = $_SESSION['username'] ?? null;
if (!$loggedInUser) {
    header("Location: login.php");
    exit;
}

// Who's cookbook are we viewing? default to logged in user
$viewUser = $_GET['user'] ?? $loggedInUser;

// Load recipes for $viewUser
$recipes = [];
$xmlFile = "data/cookbooks/{$viewUser}.xml";
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    foreach ($xml->recipe as $r) {
    $recipes[] = [
        'id' => (string)$r['id'], // FIXED: direct attribute access
        'title' => (string)$r->title,
        'description' => isset($r->description) ? (string)$r->description : '',
        'tags' => isset($r->tags) ? (string)$r->tags : '',
    ];
}
}

// Get list of all users who have cookbooks
$usernames = [];
foreach (glob("data/cookbooks/*.xml") as $file) {
    $name = basename($file, ".xml");
    $usernames[] = $name;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($viewUser); ?>'s Cookbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0 text-primary"><?php echo htmlspecialchars($viewUser); ?>'s Cookbook</h2>
        <div>
            <!-- Quick links -->
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary me-2">My Dashboard</a>
            <a href="add_recipe.php" class="btn btn-sm btn-success">Add Recipe</a>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="mb-2">Explore other Cookbooks:</h6>
        <?php foreach ($usernames as $name): ?>
            <a href="?user=<?php echo urlencode($name); ?>"
               class="badge <?php echo $name === $viewUser ? 'bg-primary' : 'bg-secondary'; ?> text-decoration-none me-1">
               <?php echo htmlspecialchars($name); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Recipe list -->
    <div class="row" id="recipeList">
        <?php if (empty($recipes)): ?>
            <div class="col-12">
                <div class="alert alert-warning">No recipes found for <?php echo htmlspecialchars($viewUser); ?>.</div>
            </div>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-4 mb-4 recipe-item">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="view_recipe.php?user=<?php echo urlencode($viewUser); ?>&id=<?php echo urlencode($recipe['id']); ?>">
                                    <?php echo htmlspecialchars($recipe['title']); ?>
                                </a>
                            </h5>
                            <?php if (!empty($recipe['description'])): ?>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($recipe['description']); ?></p>
                            <?php endif; ?>
                            <div class="mt-auto card-footer">
                                <small class="text-muted">Tags: <?php echo htmlspecialchars($recipe['tags']); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
