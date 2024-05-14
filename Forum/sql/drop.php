<?php
require_once('sqlTools.php');

$query = "DROP TABLES users, posts, comments";

//MODIFIY DATABASE
$db = getConnection();

if(mysqli_query($db, $query)) {
    echo "FORUM TABLES SUCCESSFULLY REMOVED\n";
} else {  
    echo "FAILED TO REMOVE FORUM TABLES\n";
    die();
}

closeConnection($db);

?>