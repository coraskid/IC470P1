<?php
// Connect to the SQLite database
$db = new PDO('sqlite:forum.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all posts
$sql = "SELECT * FROM posts";
$statement = $db->query($sql);
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
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
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['description']); ?></td>
                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    <td>7 <button type="button">Like</button></td>
                    <td><button type="button">Dislike</button></td>
                    <td>
                        <button type="button" class="collapsible">Comments</button>
                        <div class="content">
                            <p>No comments yet.</p>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No posts found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
    