<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-page"> <!-- Add the home-page class -->

<?php include 'navbar.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

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
