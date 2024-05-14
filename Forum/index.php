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
<?php include 'navbar.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="home-page"> <!-- Add the home-page class -->
    <?php include 'navbar.php'; ?>
    <div class="container">
        <p>hello</p>
        <?php 
        // Check if a specific page is requested
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        // Include the requested page content
        switch ($page) {
            case 'home':
                include 'home.php'; // Consider renaming index.php to home.php for clarity
                break;
            case 'about':
                include 'about.php';
                break;
            case 'post':
                include 'post.php';
                break;
            default:
                include 'home.php'; // Default to home page
                break;
        }
        ?>
    </div>
</body>

</html>
