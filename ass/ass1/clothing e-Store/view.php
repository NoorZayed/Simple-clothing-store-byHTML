<?php
  include("header.html");
// Include necessary files and initialize database connection
require_once('dbconfig.inc.php');
$pdo = db_connect();

// Define the displayProdcutPage method
function displayProdcutPage($product)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>View Product</title>
    </head>
    <body>
    <header>
       
    </header>
    <hr>
    <main>
        <h2>Product Details</h2>
        <figure> <img src="images/<?php echo $product['image_name']; ?>" alt="Product Image"></figure>
        <section>
            <h2><strong>Product ID:</strong> <?php echo $product['product_id']; ?>, <strong>Product Name:</strong> <?php echo $product['product_name']; ?></h2>
            <ul>
                <li><strong>Price:</strong> <?php echo $product['price']; ?></li>
                <li><strong>Category:</strong> <?php echo $product['category']; ?></li>
                <li><strong>Rating:</strong> <?php echo $product['rating'] . "/5"; ?></li>
            </ul>
        </section>
        <section>
            <h2><strong>Description:</strong></h2>
            <?php echo implode(' ', array_slice(explode(' ', $product['description']), 0, 15)); ?>
            <?php
            // Split the description into separate points
            $description_points = explode("\n", $product['description']);
            ?>
            <ul>
                <?php
                // Loop through each description point and display it as a list item
                foreach ($description_points as $point) {
                    echo "<li>$point</li>";
                }
                ?>
            </ul>
        </section>
    </main>
    <footer>
    <?php
  include("footer.html");?>
    </footer>
    </body>
    </html>
    <?php
}

// Check if a product ID is provided in the query string
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve product details from the database
    $query = "SELECT * FROM productstable WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a valid product is found
    if ($product) {
        // Display product details
        displayProdcutPage($product);
    } else {
        // If invalid product ID, display error message
        echo "<h3>Invalid Product ID. Product not found.</h3>";
    }
} else {
    // If no product ID provided, display error message
    echo "<h3>No Product ID provided.</h3>";
}

?>
