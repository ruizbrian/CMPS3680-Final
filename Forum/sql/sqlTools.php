<?php
require_once('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getConnection()
{
    global $servername, $username, $password, $dbname;
    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    if (!$mysqli) {
        echo 'DATABASE CONNECTION ERROR: ' . mysqli_connect_error();
        die();
    }
    return $mysqli;
}


function closeConnection($conn)
{
    if (mysqli_close($conn)) {
        return true;
    } else {
        echo 'UNABLE TO CLOSE DATABASE';
        die();
    }
}
