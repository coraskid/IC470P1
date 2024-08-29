<?php


error_reporting(E_ALL);
$id = $_GET['id'];
$upvotes = 'upvotes';
$db = new PDO('sqlite:forum.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE posts SET $upvotes = $upvotes + 1 WHERE id = :id";

$statement = $db->prepare($sql);
$statement->bindParam(':id',$id);
$statement->execute();
?>