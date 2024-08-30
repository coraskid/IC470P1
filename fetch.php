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
            <?php foreach ($posts as $post): ?>
                <tr class="clickable" onclick="toggleDetails(<?php echo $post['id']; ?>)">
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['description']); ?></td>
                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($post['upvotes']); ?>
                        <?php echo "<a href='vote.php?type=post&id=".$post['id']."'><button>Like</button></a>";?></td>
                    <td><?php echo htmlspecialchars($post['downvotes']); ?>
                        <?php echo "<a href='vote_dislike.php?type=post&id=".$post['id']."'><button>Dislike</button></a>";?></td>
                    <td><?php echo "<a href='comment.php?id=" . $post['id']."'>Add Comments</a>"; ?></td>
                </tr>
                <?php
                $sql_comments = "SELECT id, description, upvotes, downvotes FROM comments WHERE post_id = :post_id";
                $stmt_comments = $db->prepare($sql_comments);
                $stmt_comments->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
                $stmt_comments->execute();
                $comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($comments as $comment): ?>
                    <tr class="comment">
                        <td></td>
                        <td><?php echo htmlspecialchars($comment['id']); ?></td>
                        <td><?php echo htmlspecialchars($comment['description']); ?></td>
                        <td></td>
                        <td><?php echo isset($comment['upvotes']) ? htmlspecialchars($comment['upvotes']) : '0'; ?>
                            <?php echo "<a href='vote.php?type=comment&id=".$comment['id']."'><button>Like</button></a>";?></td>
                        <td><?php echo isset($comment['downvotes']) ? htmlspecialchars($comment['downvotes']) : '0'; ?>
                            <?php echo "<a href='vote_dislike.php?type=comment&id=".$comment['id']."'><button>Dislike</button></a>";?></td>
                        <td><?php echo "<a href='reply.php?id=" . $comment['id']."'>Reply</a>"; ?></td>
                    </tr>
                    <?php
                    $sql_replies = "SELECT id, description, upvotes, downvotes FROM replies WHERE comment_id = :comment_id";
                    $stmt_replies = $db->prepare($sql_replies);
                    $stmt_replies->bindParam(':comment_id', $comment['id'], PDO::PARAM_INT);
                    $stmt_replies->execute();
                    $replies = $stmt_replies->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($replies as $reply): ?>
                        <tr class="reply">
                            <td></td>
                            <td></td>
                            <td><?php echo htmlspecialchars($reply['description']); ?></td>
                            <td></td>
                            <td><?php echo isset($reply['upvotes']) ? htmlspecialchars($reply['upvotes']) : '0'; ?>
                                <?php echo "<a href='vote.php?type=reply&id=".$reply['id']."'><button>Like</button></a>";?></td>
                            <td><?php echo isset($reply['downvotes']) ? htmlspecialchars($reply['downvotes']) : '0'; ?>
                                <?php echo "<a href='vote_dislike.php?type=reply&id=".$reply['id']."'><button>Dislike</button></a>";?></td>
                            <td></td>
                        </tr>
                    <?php endforeach;?>
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