<?php
include 'config.php';

try {
    // Test connection and check if the 'topics' table exists
    $result = $conn->query("SELECT name FROM sqlite_master WHERE type='table' AND name='topics'");

    if ($result->fetch()) {
        echo "Connection successful and 'topics' table exists.";
    } else {
        echo "'topics' table does not exist.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
