<?php
class Product {
    private $product_id;
    private $product_name;
    private $category;
    private $description;
    private $price;
    private $quantity;
    private $image_name;
    private $rating;
   
   

  public function __construct($image_name,$product_id, $product_name, $category, $price, $quantity) {
    $this->image_name = $image_name;
    $this->product_id = $product_id;
    $this->product_name = $product_name;
    $this->category = $category;
    $this->price = $price;
    $this->quantity = $quantity;
  
  }
  // Setter methods
  public function setImageName($image_name) {
    $this->image_name = $image_name;
}

public function setProductId($product_id) {
    $this->product_id = $product_id;
}

public function setProductName($product_name) {
    $this->product_name = $product_name;
}

public function setCategory($category) {
    $this->category = $category;
}

public function setDescription($description) {
    $this->description = $description;
}

public function setPrice($price) {
    $this->price = $price;
}

public function setQuantity($quantity) {
    $this->quantity = $quantity;
}

public function setRating($rating) {
    $this->rating = $rating;
}

// Getter methods
public function getImageName() {
    return $this->image_name;
}

public function getProductId() {
    return $this->product_id;
}

public function getProductName() {
    return $this->product_name;
}

public function getCategory() {
    return $this->category;
}

public function getDescription() {
    return $this->description;
}

public function getPrice() {
    return $this->price;
}

public function getQuantity() {
    return $this->quantity;
}

public function getRating() {
    return $this->rating;
}
  
  public function displayInTable() {
    
    $row = <<<REC
       <tr>
       <td>{$this->image_name}</td>
       <td{$this->product_id}</td>
       <td>{$this->product_name}</td>
       <td>{$this->category}</td>
       <td>{$this->price}</td>
       <td>{$this->quantity}</td>
     
       </tr>
   REC;
      return $row;
   }
}

?>