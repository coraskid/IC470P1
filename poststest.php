<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to the SQLite database
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

   } catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
