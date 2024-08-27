<?php
include 'config.php';  // Include the database configuration
include 'functions.php';  // Include any utility functions

// Check if a topic ID is provided
if (!isset($_GET['id'])) {
    die("Topic ID is required.");
}

$topic_id = $_GET['id'];

// Fetch the topic details from the SQLite database
$sql = "SELECT title, description, upvotes, downvotes FROM topics WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $topic_id, PDO::PARAM_INT);
$stmt->execute();
$topic = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the topic exists
if (!$topic) {
    die("Topic not found.");
}

// Display the topic details
echo "<h1>" . htmlspecialchars($topic['title']) . "</h1>";
echo "<p>" . htmlspecialchars($topic['description']) . "</p>";
echo "<p>Upvotes: " . $topic['upvotes'] . " | Downvotes: " . $topic['downvotes'] . "</p>";

// Handle new comment submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $content = sanitizeInput($_POST['comment']);

    // Insert the new comment into the comments table
    $sql = "INSERT INTO comments (topic_id, content) VALUES (:topic_id, :content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

// Fetch all comments for the topic from the SQLite database
$sql = "SELECT id, content, upvotes, downvotes FROM comments WHERE topic_id = :topic_id ORDER BY (upvotes - downvotes) DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display all comments
echo "<h2>Comments</h2>";
foreach ($comments as $comment) {
    echo "<div>";
    echo "<p>" . htmlspecialchars($comment['content']) . "</p>";
    echo "<p>Upvotes: " . $comment['upvotes'] . " | Downvotes: " . $comment['downvotes'] . "</p>";
    echo "<a href='vote.php?type=comment&id=" . $comment['id'] . "&vote=up'>Upvote</a> | ";
    echo "<a href='vote.php?type=comment&id=" . $comment['id'] . "&vote=down'>Downvote</a>";
    echo "</div><hr>";
}
?>

<!-- Form for adding a new comment -->
<form method="post">
    <textarea name="comment" required></textarea><br>
    <input type="submit" value="Add Comment">
</form>
<a href="index.php">Back to Home</a>
