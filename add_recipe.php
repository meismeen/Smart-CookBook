<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

requireLogin();

$username = $_SESSION['username'];
$cookbookPath = "data/cookbooks/{$username}.xml";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $tags = $_POST['tags'];
    $id = uniqid('r');  // Generate unique ID

    // Load or create user's cookbook
    if (file_exists($cookbookPath)) {
        $xml = loadXML($cookbookPath);
    } else {
        $xml = new SimpleXMLElement("<cookbook></cookbook>");
    }

    $newRecipe = $xml->addChild("recipe");
    $newRecipe->addAttribute('id', $id);
    $newRecipe->addChild("title", htmlspecialchars($title));
    $newRecipe->addChild("ingredients", htmlspecialchars($ingredients));
    $newRecipe->addChild("steps", htmlspecialchars($steps));
    $newRecipe->addChild("tags", htmlspecialchars($tags));

    saveXML($xml, $cookbookPath);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Add a New Recipe</h1>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Ingredients (comma-separated):</label><br>
        <textarea name="ingredients" required></textarea><br><br>

        <label>Steps:</label><br>
        <textarea name="steps" required></textarea><br><br>

        <label>Tags (comma-separated):</label><br>
        <input type="text" name="tags"><br><br>

        <button type="submit">Add Recipe</button>
    </form>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>
