<?php
require_once('sqlTools.php');

$query = "DROP TABLE product";

//MODIFIY DATABASE
$db = getConnection();

if(mysqli_query($db, $query)) {
    echo "PRODUCT TABLE SUCCESSFULLY REMOVED\n";
} else {  
    echo "FAILED TO REMOVE PRODUCT TABLE\n";
    die();
}

closeConnection($db);

?>