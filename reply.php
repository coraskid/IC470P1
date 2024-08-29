<?php

if (!isset($_GET['id'])) {
    die("Need Comment ID");
}


$comment_id = $_GET['id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Connect to the SQLite database
try {
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $description = $description . ' ' . " | IN REPLY TO $comment_id";

    // Prepare the insert statement
    $stmt = $db->prepare("INSERT INTO replies (comment_id, description) VALUES (:comment_id, :description)");

    // Bind parameters
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->bindParam(':description', $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Reply made successfully!";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Replies</title>
    </head>
    <body>
        <h1>Reply To Post</h1>
        <h2>
            <a href="index.php">return to main page!</a>
            <a href="fetch.php">View Sumbissions!</a>
        </h2>
        <!-- Form to submit a new post -->
        <form action="" method="post">
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit">Submit</button>
        </form>

        <hr>
    </body>
</html>