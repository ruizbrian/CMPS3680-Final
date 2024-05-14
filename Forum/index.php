<?php
// Include necessary files
require_once('sql/sqlTools.php');

// Initialize an array to store post titles
$posts = array();

// Fetch post titles from the database
$mysqli = getConnection();
$sql = "SELECT id, title, created_at FROM posts ORDER BY created_at DESC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    $result->free();
}

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="home-page">
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Forum</h1>
        <a href="post.php" class="btn btn-primary">Create New Post</a>
        <div class="posts">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="post">
                        <h2><a href="view_post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
                        <p>Created on <?php echo $post['created_at']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
