<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include the database connection file
require_once "sql/sqlTools.php";
$mysqli = getConnection();

// Define variables and initialize with empty values
$title = $content = "";
$title_err = $content_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter the title of your post.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content of your post.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($content_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iss", $param_user_id, $param_title, $param_content);

            // Set parameters
            $param_user_id = $_SESSION["id"];
            $param_title = $title;
            $param_content = $content;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to home page after successful post
                header("location: home.php");
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
    <title>Post Question</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="wrapper">
        <h2>Create a New Post</h2>
        <p>Please fill in the following fields to create a new post.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                <label>Content</label>
                <textarea name="content" class="form-control"><?php echo $content; ?></textarea>
                <span class="help-block"><?php echo $content_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Post">
            </div>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>

</html>
