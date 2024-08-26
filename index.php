

<?php
// Simple PHP variable

// Connect to the SQLite database
$db = new PDO('sqlite:forum.db');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $url = $_POST['url'];

    // Insert the new post into the database
    $stmt = $db- prepare("INSERT INTO posts (title, url) VALUES (:title, :url)");
    $stmt-bindParam(':title', $title);
    $stmt-bindParam(':url', $url);
    $stmt-bindValue(':created_at', date('Y-m-d H:i:s')); // Current timestamp
    $stmt-execute();
}

// Fetch all posts from the database, ordered by newest first
$posts = $db-query("SELECT * FROM posts ORDER BY created_at DESC")-fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Forum</title>
</head>
<body>
    <?php
    echo "hello";
    ?>
    <h1>Simple Forum!</h1>

    <!-- Form to submit a new post -->
    <form action="" method="post">
        <input type="text" name="title" placeholder="Title" required>
        <input type="url" name="url" placeholder="URL" required>
        <button type="submit">Submit</button>
    </form>

    <hr>

    <!-- List all posts -->
    <!-- <?php foreach ($posts as $post): ?>
        <div>
            <a href="<?php echo htmlspecialchars($post['url']); ?>">
                <?php echo htmlspecialchars($post['title']); ?>
            </a>
            <small>(<?php echo $post['created_at']; ?>)</small>
        </div>
    <?php endforeach; ?> -->

    
    
    <?php
    $db = new PDO('sqlite:forum.db');
    $db-setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch all posts from the database, ordered by newest first
    $posts = $db-query("SELECT * FROM posts ORDER BY created_at DESC")-fetchAll(PDO::FETCH_ASSOC);
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
        </style>
    </head>
    <body>

    <h1>Posts</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>URL</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($posts): ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['id']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($post['url']); ?>"><?php echo htmlspecialchars($post['url']); ?></a></td>
                        <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No posts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


</body>
</html>