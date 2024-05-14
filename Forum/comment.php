<?php
session_start();

// Include the database connection file
require_once "sql/sqlTools.php";

$mysqli = getConnection();

// Check if the 'post_id' parameter is set in the POST data
if(isset($_POST["post_id"]) && !empty(trim($_POST["post_id"]))){
    // Store the post ID from the POST data
    $post_id = $_POST["post_id"];
} else {
    // 'post_id' parameter is not set in POST data, redirect to error page or display message
    echo "Post ID not specified.";
    exit();
}

// Check if the post exists
$sql = "SELECT id, title FROM posts WHERE id = ?";
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $param_post_id);

    // Set parameters
    $param_post_id = $post_id;

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();

        // Check if post exists
        if($stmt->num_rows == 1){
            $stmt->bind_result($post_id, $post_title);
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

// Define variables and initialize with empty values
$content = "";
$content_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter your comment.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Check input errors before inserting into database
    if (empty($content_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iis", $param_user_id, $param_post_id, $param_content);

            // Set parameters
            $param_user_id = $_SESSION["id"];
            $param_post_id = $post_id;
            $param_content = $content;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to view_post.php after successful comment
                header("location: view_post.php?id=" . $post_id);
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment on Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="wrapper">
        <h2>Comment on Post: <?php echo htmlspecialchars($post_title); ?></h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                <label>Comment</label>
                <textarea name="content" class="form-control"><?php echo $content; ?></textarea>
                <span class="help-block"><?php echo $content_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Post Comment">
                <a href="view_post.php?id=<?php echo $post_id; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
