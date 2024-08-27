<?php
include 'config.php';

if (!isset($_GET['type']) || !isset($_GET['id']) || !isset($_GET['vote'])) {
    die("Invalid parameters.");
}

$type = $_GET['type'];
$id = (int)$_GET['id'];
$voteColumn = $_GET['vote'] === 'up' ? 'upvotes' : 'downvotes';

if ($type === 'topic') {
    $sql = "UPDATE topics SET $voteColumn = $voteColumn + 1 WHERE id = :id";
} elseif ($type === 'comment') {
    $sql = "UPDATE comments SET $voteColumn = $voteColumn + 1 WHERE id = :id";
} else {
    die("Invalid vote type.");
}

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: index.php");
?>
