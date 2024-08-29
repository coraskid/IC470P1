<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="accstyles.css"> 
</head>
<?php
// Connect to the SQLite database
$db = new PDO('sqlite:forum.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all posts
$sql = "SELECT * FROM posts";
$statement = $db->query($sql);
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

function vote($entry) {
    $id = $entry['id'];
    $sql = "UPDATE posts SET $upvotes = $upvotes + 1 WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    // if ($db->query($sql) === TRUE) {
    //     echo "Record updated successfully";
    // } else {
    //     echo "Error updating record: " . $db->error;
    // }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .content {
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var collapsibles = document.getElementsByClassName("collapsible");
            for (var i = 0; i < collapsibles.length; i++) {
                collapsibles[i].addEventListener("click", function() {
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        });
    </script>
</head>
<body>

<h1>Posts</h1>
<h2> 
    <a href="test.php">Submit a post!</a>
    <a href="index.php">Main page</a>
</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Like</th>
            <th>Dislike</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($posts): ?>
            <?php $count = 0; foreach ($posts as $post): ?>
                <tr class="clickable" onclick="toggleDetails('comments')">
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['description']); ?></td>
                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($post['upvotes']); ?>
                        <a href="index.php"><button>Like</button></a></td>
                    <td><?php echo htmlspecialchars($post['downvotes']); ?>
                        <button onclick="vote($post)" type="button">Dislike</button></td>
                    <td><?php echo "<a href='comment.php?id=" . $post['id']."'>Add Comments</a>"?></td>
                </tr>
                <?php 
                $db = new PDO('sqlite:forum.db');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT id, description FROM comments WHERE post_id = ".$post['id'];
                $statement2 = $db->query($sql);
                $comments = $statement2->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php $x = 0; foreach ($comments as $comment): ?>
                    <tr id= <?php $x ?> class="comment">
                        <td><?php echo htmlspecialchars($comment['id']); ?></td>
                        <td><?php echo htmlspecialchars($comment['description']); $x++;?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No posts found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<script src="accordian.js"></script> 
</body>
</html>
    