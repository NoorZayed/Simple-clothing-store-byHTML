<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Record</title>
</head>
<body>
<header>
  
</header>
       <?php
         include("header.html");
       ?>
<fieldset>
  <legend>
   Product Record </legend>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name"><br>
        <br>

        <label for="category">Category:</label>
        
        <select name="category" id="category">
            <option value="">Select Category</option>
            <option value="Dresses">Dresses</option>
            <option value="Suit">Suit</option>
            <option value="Skirt">Skirt</option>
            <option value="Tops">Tops</option>
            <option value="other">Other</option>
        </select><br>
        
        <br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price"><br>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity"><br>
        <br>
        <label for="rating">Rating:</label>
        <input type="number" name="rating" id="rating" min="0" max="5"><br>
        <br>
       
        <section>
        <label for="description">Description:</label> 
        <br>
        <textarea name="description" id="description" cols="80" rows="6"  placeholder="Provide a full description about the prodcut"></textarea><br>
        </section>
        <br>
        <label for="prodcut_photo">Prodcut Photo:</label>
        <input type="file" name="prodcut_image" id="prodcut_image"><br>
        <br>
        <input type="submit" value="Insert">
    </form>
    </fieldset>
    <footer>
    <?php
  include("footer.html");?>
</footer>
</body>


</html>
<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    
    // Validate and sanitize input data (you may add more validation)
    // Example validation: Ensure required fields are not empty
    if (empty($product_name) || empty($category) || empty($price) || empty($quantity) || empty($rating)) {
        echo "Please fill in all required fields.";
    } else {
        // Database connection and insertion (replace with your database code)
        // Assuming you have a database connection established
        require_once('dbconfig.inc.php');
        $pdo = db_connect();
        
        // Insert product details into the database
        $query = "INSERT INTO productstable (product_name, category, price, quantity, rating, description, image_name) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$product_name, $category, $price, $quantity, $rating, $description, basename($_FILES["prodcut_image"]["name"])]);

        // Retrieve the auto-generated product ID after insertion
        $product_id = $pdo->lastInsertId();

        // Upload product photo
        $target_dir = "images/";
        $original_file_name = basename($_FILES["prodcut_image"]["name"]);
        $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
        $new_file_name = $product_id . ".jpeg";
        $target_file = $target_dir . $new_file_name;

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["prodcut_image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars($original_file_name) . " has been uploaded.";
            
            // Update image name in the database
            $query = "UPDATE productstable SET image_name = ? WHERE product_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$new_file_name, $product_id]);

            // Close database connection
            $pdo = null;

            echo "Product added successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
