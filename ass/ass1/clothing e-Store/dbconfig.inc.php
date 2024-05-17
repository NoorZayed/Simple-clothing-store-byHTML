<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'p');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
// function db_connect($dbhost = DBHOST, $dbname = DBNAME , $username = DBUSER, $password = DBPASS){
//   try {
//   $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   // $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);

//   return $pdo;
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }

function db_connect($dbhost = DB_HOST, $dbname = DB_NAME , $username = DB_USER, $password = DB_PASSWORD){
  try {
      /*
      * Create the pdo object
      * host: is the host name
      * dbname: database name
      */

      $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);

      return $pdo;

  } catch (PDOException $e) {
      die($e->getMessage());
  }
}

// }