<?php
// Connect to the SQLite database

try {
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Directly insert a test post
    $stmt = $db->prepare("INSERT INTO posts (title, description) VALUES (:title, :description)");
    $stmt->execute([':title' => 'Test Title', ':description' => 'Test Description']);

    echo "Test post added successfully!";
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}

try {
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check the table structure
    $result = $db->query("PRAGMA table_info(posts)")->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($result);
    echo "</pre>";

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}


?>