<?php
// Check if product ID is provided in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Retrieve product ID from the URL
    $product_id = $_GET['id'];

    // Perform database deletion here (replace with your database code)
    require_once('dbconfig.inc.php');
    $pdo = db_connect();
    
    $query = "DELETE FROM productstable WHERE product_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_id]);
    
    // Close database connection
    $pdo = null;

    // Redirect back to the products page after deletion
    header("Location: products.php");
    exit();
} else {
    // If product ID is not provided, redirect back to the products page
    header("Location: products.php");
    exit();
}
?>
