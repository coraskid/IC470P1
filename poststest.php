<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to the SQLite database
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert a test post
    $stmt = $db->prepare("INSERT INTO posts (title, description) VALUES (:title, :description)");
    $stmt->execute([':title' => 'Cooper', ':description' => 'Walshe']);

    echo "Test post added successfully!<br>";

    // Fetch and display all posts
    $posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    if ($posts) {
        echo "<h2>Posts in the database:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Created At</th></tr>";
        foreach ($posts as $post) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($post['id']) . "</td>";
            echo "<td>" . htmlspecialchars($post['title']) . "</td>";
            echo "<td>" . htmlspecialchars($post['description']) . "</td>";
            echo "<td>" . htmlspecialchars($post['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No posts found.<br>";
    }

    // Check the table structure
    $result = $db->query("PRAGMA table_info(posts)")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Table Structure:</h2>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Forum</title>
</head>
<body>
    <h1>Forum Submission</h1>
    <h2> 
        <a href="index.php">return to main page!</a>
    </h2>
    <!-- Form to submit a new post -->
    <form action="" method="post">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit">Submit</button>
    </form>

    <hr>
</body>
</html>