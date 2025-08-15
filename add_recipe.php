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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        textarea, input {
            resize: none;
        }
        button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add a New Recipe</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" placeholder="Enter recipe title" required>
        </div>

        <div class="mb-3">
            <label>Ingredients (comma-separated):</label>
            <textarea name="ingredients" class="form-control" placeholder="E.g. sugar, flour, milk" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Steps:</label>
            <textarea name="steps" class="form-control" placeholder="Write step-by-step instructions" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label>Tags (comma-separated):</label>
            <input type="text" name="tags" class="form-control" placeholder="E.g. dessert, quick, vegan">
        </div>

        <button type="submit">➕ Add Recipe</button>
    </form>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>