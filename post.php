<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Questions - Forum Website</title>
    <link rel="stylesheet" href="css/style.css">
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
    <h1>Post Questions</h1>
    <!-- Form for posting questions -->
    <form action="scripts/post_question.php" method="post">
        <label for="question">Your Question:</label><br>
        <textarea id="question" name="question" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Post Question">
    </form>
    
    <!-- Display existing questions -->
    <h2>Existing Questions</h2>
    <div class="questions">
        <?php
        // Include the database connection file
        include 'includes/db.php';

        // Retrieve existing questions from the database
        $sql = "SELECT * FROM Questions ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);

        // Display each question
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='question'>";
            echo "<p>" . $row['question'] . "</p>";
            // Add form for posting comments on each question
            echo "<form action='scripts/post_comment.php' method='post'>";
            echo "<input type='hidden' name='question_id' value='" . $row['id'] . "'>";
            echo "<label for='comment'>Your Comment:</label><br>";
            echo "<textarea id='comment' name='comment' rows='2' cols='50' required></textarea><br>";
            echo "<input type='submit' value='Post Comment'>";
            echo "</form>";
            echo "</div>";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</div>

</body>
</html>
