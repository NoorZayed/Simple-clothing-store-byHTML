<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
<header>
   
</header>
<hr>
<?php
  include("header.html");
require_once('dbconfig.inc.php');

// Check if product ID is provided
if (!isset($_GET['id'])) {
    // Redirect back to products page if product ID is not provided
    header("Location: products.php");
    exit();
}

// Retrieve product details from the database based on the product ID
$pdo = db_connect();
$query = "SELECT * FROM productstable WHERE product_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if product exists
if (!$product) {
    // Redirect back to products page if product does not exist
    header("Location: products.php");
    exit();
}

// Handle form submission for updating product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data (you may add more validation)
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    
    // Update product details in the database
    $query = "UPDATE productstable SET product_name = ?, price = ?, quantity = ?, rating = ?, description = ? WHERE product_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_name, $price, $quantity, $rating, $description, $_GET['id']]);
    // Check if a new image file is uploaded
    if ($_FILES['product_image']['name']) {
        // Upload new product image
        $target_dir = "images/";
        $product_photo = $target_dir . $_GET['id'] . ".jpeg";
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $product_photo);

        // Update image name in the database
        $query = "UPDATE productstable SET image_name = ? WHERE product_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_GET['id'] . ".jpeg", $_GET['id']]);
    }

    // Redirect to products page after updating
    header("Location: products.php");
    exit();
}
?>
<section>
<fieldset>
<legend>Edit Product</legend>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>" method="post" enctype="multipart/form-data">
    <label for="product_id">Product ID:</label>
    <input type="text" name="product_id" id="product_id" value="<?php echo $product['product_id']; ?>" disabled><br>
    <br>
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" id="product_name" value="<?php echo $product['product_name']; ?>"><br>
    <br>
    <label for="category">Category:</label>
    <input type="text" name="category" id="category" value="<?php echo $product['category']; ?>" disabled><br>
    <br>
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" value="<?php echo $product['price']; ?>"><br>
    <br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" value="<?php echo $product['quantity']; ?>"><br>
    <br>
    <label for="rating">Rating:</label>
    <input type="number" name="rating" id="rating" min="0" max="5" value="<?php echo $product['rating']; ?>"><br>
    <br>
    <label for="description">Description:</label> 
    <br>
    <textarea name="description" id="description" cols="80" rows="6"><?php echo $product['description']; ?></textarea><br>
    <br>
    <label for="product_image">Product Image:</label>
    <input type="file" name="product_image" id="product_image"><br>
    <br>
    <input type="submit" value="Update Product">
</form>
</fieldset>
</section>
<footer>
<?php
  include("footer.html");?>
</footer>
</body>
</html>
