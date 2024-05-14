<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="index.php">Home</a>
        </div>
        <div class="navbar-links">
            <a href="about.php">About</a>
            <a href="post.php">Post</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    // Check if a specific page is requested
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    // Include the requested page content
    switch ($page) {
        case 'home':
            include 'pages/home.php';
            break;
        case 'about':
            include 'pages/about.php';
            break;
        case 'post':
            include 'pages/post.php';
            break;
        default:
            include 'pages/home.php'; // Default to home page
            break;
    }
    ?>
</div>

</body>
</html>
