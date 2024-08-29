<?php

if (!isset($_GET['id'])) {
    die("Need Post ID");
}
$post_id = $_GET['id'];


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

    // Prepare the insert statement
    $stmt = $db->prepare("INSERT INTO comments (post_id, description) VALUES (:post_id, :description)");

    // Bind parameters
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':description', $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Post added successfully!";
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
    <title>Comments</title>
</head>
<body>
    <h1>Add Comments</h1>
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