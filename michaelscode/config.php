<?php
try {
    // Create (connect to) SQLite database in file
    $conn = new PDO('sqlite:forum.db');

    // Set error mode to exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
