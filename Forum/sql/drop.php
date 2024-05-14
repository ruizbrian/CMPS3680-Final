<?php
require_once('sqlTools.php');

// Close existing connections to release locks
$db = getConnection();
closeConnection($db);

// Disable foreign key checks
$queryDisableFK = "SET FOREIGN_KEY_CHECKS=0";
$db = getConnection(); // Reopen connection
mysqli_query($db, $queryDisableFK);

// Drop tables
$queryDropTables = "DROP TABLE users, posts, comments";

if(mysqli_query($db, $queryDropTables)) {
    echo "Forum tables successfully removed\n";
} else {  
    echo "Failed to remove forum tables\n";
    die();
}

// Enable foreign key checks
$queryEnableFK = "SET FOREIGN_KEY_CHECKS=1";
mysqli_query($db, $queryEnableFK);

// Close connection
closeConnection($db);
?>
