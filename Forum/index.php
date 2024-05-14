<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'navbar.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Website</title>
    <!-- Link Bootstrap CSS before your custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="home-page"> <!-- Add the home-page class -->
    <div class="container">

        <p>hello</p>
<?php 
        // Check if a specific page is requested
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    // Include the requested page content
    switch ($page) {
        case 'about':
            include 'about.php';
            break;
        case 'post':
            include 'post.php';
            break;
        default:
            include 'index.php'; // Default to home page
            break;
    }
    ?>
    </div>
</body>

</html>
