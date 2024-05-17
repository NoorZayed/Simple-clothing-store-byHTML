
<!DOCTYPE html>
<html>
<head>
  <title>E-Clothing Store - Products</title>
</head>
<body>
<header>
<?php
         include("header.html");
       ?>
</header>
          <hr>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('dbconfig.inc.php');
include_once('Product.php');


$pdo = db_connect(); 
$categories_query = "SELECT DISTINCT category FROM productstable";
            $categories_result = $pdo->query($categories_query);
            $categories = $categories_result->fetchAll(PDO::FETCH_COLUMN);
            foreach ($categories as $category) {
                // echo "<option value=\"$category\">$category</option>";
            }


$query1 = "SELECT * FROM productstable";
// Retrieve search criteria
$search = isset($_POST['search']) ? $_POST['search'] : '';
$search_by = isset($_POST['search_by']) ? $_POST['search_by'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';

try {
  // Check if the form has been submitted via POST
// Check if the form has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve search criteria from the form submission
  $search = isset($_POST['search']) ? $_POST['search'] : '';
  $search_by = isset($_POST['search_by']) ? $_POST['search_by'] : '';
  $category = isset($_POST['category']) ? $_POST['category'] : '';

  // Check if the user has chosen a search criteria
  if (empty($search_by)&& empty($category)) {
      echo "You must choose how to search (Name, Category, or Price).";
  } else {
      // Construct the query based on the chosen search criteria
      try {
          // Start constructing the query
          $query1 = "SELECT * FROM productstable";

          // Add WHERE clause if search term is provided
          if (!empty($search)&& empty($category)) {
              $query1 .= " WHERE ";
              if ($search_by === 'product_name') {
                  $query1 .= "product_name LIKE '%$search%'";
              } elseif ($search_by === 'category') {
                  $query1 .= "category = '$category'";
              } elseif ($search_by === 'price') {
                  $query1 .= "price >= $search";
              }
          } elseif (!empty($category)&& empty($search)) {
              // If category is selected without search term
              $query1 .= " WHERE category = '$category'";
          }else{
            $query1 = "SELECT * FROM productstable WHERE 1=1";

            // Add WHERE clause if search term is provided
            // Add WHERE clause if search term is provided
            if (!empty($search)) {
              if ($search_by === 'product_name') {
                  $query1 .= " AND product_name LIKE '%$search%'";
              } elseif ($search_by === 'price') {
                  $query1 .= " AND price >= $search";
              } elseif ($search_by === 'category') {
                  // If both category filters are selected, display an error message
                  if (!empty($category)) {
                      echo "~~~~~~~You cannot select two categories.~~~~~~~~~~~";
                  } else {
                      $query1 .= " AND category = '$search'";
                  }
              }
          }
            // Add WHERE clause for category if selected
            if (!empty($category)) {
                $query1 .= " AND category = '$category'";
            }}
          // Execute the query
          $result = $pdo->query($query1);
      } catch (PDOException $e) {
          echo "Query Error: " . $e->getMessage();
      }
  }
}

} catch (PDOException $e) {
  throw new Exception("Error constructing query: " . $e->getMessage());
} catch (Exception $e) {
  throw new Exception("Error constructing query: " . $e->getMessage());
}

        
try {
  try {
    $result = $pdo->query($query1);
    // Fetch and display data
    if ($result) {
      // Create Product objects from database results
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         /* Create a PDOStatement object */

    $dbResults = $pdo->query($query1);
    $rows = $dbResults->fetchAll();
   
        // $product = new Product($row['product_id'], $row['product_name'], $row['category'], $row['description'], $row['price'], $row['quantity'], $row['image_name']);
        $product = new Product($row['image_name'],$row['product_id'], $row['product_name'], $row['category'], $row['price'], $row['quantity']);
      }
  } else {
      // Handle the case where the query was not successful
      echo "Error executing the query: " . $pdo->errorInfo()[2];
  }
} catch (PDOException $e) {
    echo "Query Error: " . $e->getMessage();
}

  ?>
  <section>
  <h5>
    To Add a new Product click on the following link
    <span ><a href="add.php">Add Product</a></span>
</h5>
  <h5>Or use the actions below to edit or delete a Product's record.</h5>
</section>
<section>
  <fieldset>
  <legend>Advanced Product Search</legend>
    <form method="POST" action="products.php">
        <input type="text" name="search" placeholder="Search by">
        <input type="radio" name="search_by" value="product_name"> Name
        <input type="radio" name="search_by" value="category"> Category
        <input type="radio" name="search_by" value="price"> Price
        <select name="category">
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
        <?php endforeach; ?>
    </select>
        <button type="submit">Filter</button>
    </form>
  
  <br>

        </section>
        <section>
<table border=\"0\">
<thead>
    <tr>
      <th>Product Image</th>
      <th>Product ID</th>
      <th>Product Name</th>
      <th>Category</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Actions</th>
    </tr>
</thead>
<tbody>
 
    <?php foreach ($rows as $row):?>
        <tr>
        <td><figure><img src="images/<?php echo $row['image_name']; ?>" alt="Product Image"></figure></td>

        <!-- <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['image_name']); ?>" alt="Product Image"></td> -->
        <td><a href="view.php?id=<?php echo $row['product_id'] ?>"><?php echo $row['product_id'] ?></a></td>

            <td><?php echo $row['product_name']?></td>
            <td><?php echo $row['category']?></td>
           
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['quantity']?></td>
            <td>
            <!-- Edit Button -->
            <button>
                <a href="edit.php?id=<?php echo $row['product_id']?>">
                <img src="images/edit.jpeg" alt="edit">

                </a>
            </button>
            <!-- Delete Button -->
            <button>
                <a href="delete.php?id=<?php echo $row['product_id']?>">
                <img src="images/delete.jpeg" alt="delete">

                </a>
            </button>
        </td>
    </tr>
        </tr>
    <?php endforeach;
    $pdo = null;
    ?>
   
    </tbody>
    </table>
    </section>
</fieldset>
<?php 
try{
    while ( $product = $result->fetchObject('Product') )
            echo $product->displayInTable();
}catch(PDOException $e){
  echo "ooo";
}

  while ($product = $result->fetchObject('Product')) {
    echo $product->displayInTable();
  }

} catch (PDOException $e) {
  echo "Database Error: " . $e->getMessage();
}

$pdo = null;
//  <td><?php echo $row['image_name']?></td>
    <footer>
    <?php
  include("footer.html");?>
</footer>
  </body>
    </html>



    
