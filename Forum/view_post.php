<?php
// Include the database connection file
require_once "sql/sqlTools.php";
$mysqli = getConnection();

// Check if the 'id' parameter is set in the URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Store the post ID from the URL
    $post_id = $_GET["id"];

    // Fetch the post details
    $sql = "SELECT p.id, p.title, p.content, p.created_at, u.username 
            FROM posts p JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?";
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $post_id);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();

            // Check if post exists
            if($stmt->num_rows == 1){
                // Bind result variables
                $stmt->bind_result($id, $title, $content, $created_at, $username);
                $stmt->fetch();
            } else{
                // Post not found, redirect to error page or display message
                echo "Post not found.";
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

} else{
    // 'id' parameter is not set, redirect to error page or display message
    echo "Post ID not specified.";
    exit();
}

// Fetch comments for the post
$sql = "SELECT c.id, c.content, c.created_at, u.username 
        FROM comments c JOIN users u ON c.user_id = u.id 
        WHERE c.post_id = ?";
$comments = [];
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $post_id);

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();

        // Check if comments exist
        if($stmt->num_rows > 0){
            // Bind result variables
            $stmt->bind_result($comment_id, $comment_content, $comment_created_at, $comment_username);
            while($stmt->fetch()){
                // Store each comment in an array
                $comments[] = [
                    'id' => $comment_id,
                    'content' => $comment_content,
                    'created_at' => $comment_created_at,
                    'username' => $comment_username
                ];
            }
        }
    } else{
        echo "Oops! Something went wrong while fetching comments. Please try again later.";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="wrapper">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p>Posted by: <?php echo htmlspecialchars($username); ?></p>
        <p>Posted on: <?php echo htmlspecialchars($created_at); ?></p>
        <p><?php echo htmlspecialchars($content); ?></p>
        <hr>
        <h3>Comments</h3>
        <?php if(empty($comments)): ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php else: ?>
            <ul>
            <?php foreach($comments as $comment): ?>
                <li>
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> - <?php echo htmlspecialchars($comment['created_at']); ?></p>
                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <hr>
        <h3>Add Comment</h3>
        <form action="comment.php" method="post">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"> <!-- Ensure this line is correctly passing post_id -->
    <div class="form-group">
        <label>Comment</label>
        <textarea name="content" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Post Comment">
    </div>
</form>


        <p><a href="home.php">Back to Home</a></p>
    </div>
</body>
</html>
