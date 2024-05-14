<?php
require_once('config.php');

function getConnection()
{
    $mysqli = mysqli_connect(
        $GLOBALS['servername'],
        $GLOBALS['username'],
        $GLOBALS['password'],
        $GLOBALS['dbname']
    );
    if ($mysqli) {
        return $mysqli;
    } else {
        echo 'DATABASE CONNECTION ERROR';
        die();
    }
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

function addProduct($product)
{
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "INSERT INTO products (internalId, productName, vendor, vendorPhone, quantity, lastPurchased) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssis", $product['id'], $product['productName'], $product['vendor'], $product['vendorPhone'], $product['quantity'], $product['lastPurchased']);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error adding product: " . mysqli_error($conn);
        die();
    }

    closeConnection($conn);
}

function removeProduct($id)
{
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE internalId = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error removing product: " . mysqli_error($conn);
        die();
    }

    closeConnection($conn);
}

function dumpProducts()
{
    $conn = getConnection();
    $query = "DELETE FROM products";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error dumping products: " . mysqli_error($conn);
        die();
    }

    closeConnection($conn);
}

function getProducts()
{
    $conn = getConnection();
    $query = "SELECT internalId AS id, productName, vendor, vendorPhone, quantity, lastPurchased FROM products";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error retrieving products: " . mysqli_error($conn);
        die();
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    closeConnection($conn);

    return $products;
}

function uniqueID($id)
{
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "SELECT internalId FROM products WHERE internalId = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    closeConnection($conn);

    return $num_rows == 0;
}
?>