<?php
include 'config.php';  // Include the database configuration

try {
    // Ensure the 'topics' table exists, and create it if not
    $conn->exec("CREATE TABLE IF NOT EXISTS topics (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        upvotes INTEGER DEFAULT 0,
        downvotes INTEGER DEFAULT 0
    )");

    // Ensure the 'comments' table exists, and create it if not
    $conn->exec("CREATE TABLE IF NOT EXISTS comments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        topic_id INTEGER NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        upvotes INTEGER DEFAULT 0,
        downvotes INTEGER DEFAULT 0,
        FOREIGN KEY (topic_id) REFERENCES topics(id)
    )");

    // Query to get all topics sorted by upvotes
    $sql = "SELECT id, title, description, upvotes, downvotes FROM topics ORDER BY (upvotes - downvotes) DESC";
    $stmt = $conn->query($sql);
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Topics</h1>";

    // Display all topics
    foreach ($topics as $row) {
        echo "<div>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Upvotes: " . $row['upvotes'] . " | Downvotes: " . $row['downvotes'] . "</p>";
        echo "<a href='view_topic.php?id=" . $row['id'] . "'>View Comments</a> | ";
        echo "<a href='vote.php?type=topic&id=" . $row['id'] . "&vote=up'>Upvote</a> | ";
        echo "<a href='vote.php?type=topic&id=" . $row['id'] . "&vote=down'>Downvote</a>";
        echo "</div><hr>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<a href="post_topic.php">Post a new topic</a>
