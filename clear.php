<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to the SQLite database
    $db = new PDO('sqlite:forum.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the DELETE statement to clear the table
    $stmt = $db->prepare("DELETE FROM posts");
    $stmt->execute();

    // Optionally, get the number of rows affected
    $rowCount = $stmt->rowCount();

    echo "Table cleared successfully! Number of rows deleted: " . $rowCount . "<br>";

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>