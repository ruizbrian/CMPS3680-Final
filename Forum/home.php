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
    <title>Wheelie Wisdom Forum</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    <!-- Include Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS for positioning the button */
        .create-post-btn {
            position: fixed;
            top: 60px; /* Adjust as needed */
            right: 20px;
            z-index: 1000; /* Ensure button appears above other content */
        }
    </style>
    <link rel="icon" href="doodlewheelie.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="doodlewheelie.jpg" type="image/x-icon">
</head>

<body>
    
<?php include 'navbar.php'; ?>

    <div class="container">
        <h1><u>Forum</u></h1>
        
        <!-- Button for creating a new post -->
        <a href="post.php" class="btn btn-primary mb-3 create-post-btn">
    <i class="bi bi-plus d-md-none "></i> <!-- Plus icon shown on medium and larger screens -->
    <span class="d-none d-md-inline">Create New Post</span> <!-- Text shown on small screens -->
</a>

        
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
<?php include 'footer.php'; ?>


</html>
