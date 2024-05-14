<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="index.php">Home</a>
        </div>
        <div class="navbar-links">
            <a href="about.php" <?php if(basename($_SERVER['PHP_SELF']) == 'about.php') echo 'class="active"'; ?>>About</a>
            <a href="post.php" <?php if(basename($_SERVER['PHP_SELF']) == 'post.php') echo 'class="active"'; ?>>Post</a>
            <a href="register.php" <?php if(basename($_SERVER['PHP_SELF']) == 'register.php') echo 'class="active"'; ?>>Register</a>
            <a href="login.php" <?php if(basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>>Login</a>
        </div>
    </div>
</nav>
