<?php
try {
    // Create (connect to) SQLite database in file
    $conn = new PDO('sqlite:forum.db');

    // Set error mode to exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they do not exist
    $conn->exec("CREATE TABLE IF NOT EXISTS topics (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        upvotes INTEGER DEFAULT 0,
        downvotes INTEGER DEFAULT 0
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS comments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        topic_id INTEGER NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        upvotes INTEGER DEFAULT 0,
        downvotes INTEGER DEFAULT 0,
        FOREIGN KEY (topic_id) REFERENCES topics(id)
    )");

    echo "Database and tables created successfully!";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}
?>
