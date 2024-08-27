<?php
include 'config.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitizeInput($_POST['title']);
    $description = sanitizeInput($_POST['description']);

    $sql = "INSERT INTO topics (title, description) VALUES (:title, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);

    if ($stmt->execute()) {
        echo "Topic posted successfully!";
    } else {
        echo "Error: Could not post topic.";
    }
}
?>

<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    <input type="submit" value="Post Topic">
</form>
<a href="index.php">Back to Home</a>
