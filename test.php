
<?php
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
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Prepare the insert statement
    $stmt = $db->prepare("INSERT INTO posts (title, description) VALUES (:title, :description)");

    // Bind parameters
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

// Fetch all posts from the database, ordered by newest first
$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
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