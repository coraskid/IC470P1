<?php
// Connect to the SQLite database
$db = new PDO('sqlite:forum.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Drop the table if it exists
$sql = "DROP TABLE IF EXISTS posts";
$db->exec($sql);
$sql = "DROP TABLE IF EXISTS comments";
$db->exec($sql);
$sql = "DROP TABLE IF EXISTS replies";
$db->exec($sql);

// Recreate the table with the correct schema
$sql = "CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0
)";
$db->exec($sql);
$sql = "CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    FOREIGN KEY (post_id) REFERENCES posts(id)
)";
$db->exec($sql);
$sql = "CREATE TABLE replies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    comment_id INTEGER NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    FOREIGN KEY (comment_id) REFERENCES comments(id)
)";

$db->exec($sql);

echo "Table recreated with the correct schema.";
?>