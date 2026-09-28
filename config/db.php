<?php
$host = "localhost";
$dbname = "macaroon_db";
$username = "root";
$password = "";

try {
  $pdo = new PDO(
    "mysql:host=$host;charset=utf8mb4", 
    $username,$password, 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false
    ]
  );

  $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`;");
  $pdo->exec("USE `$dbname`;");

  $queryTable = "
      CREATE TABLE IF NOT EXISTS products (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(100) NOT NULL UNIQUE,
          category VARCHAR(50) NOT NULL DEFAULT 'Classic',
          price DECIMAL(12,2) NOT NULL,
          stock INT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  $pdo->exec($queryTable);

  $checkData =$pdo->query(" SELECT COUNT(*) FROM products")->fetchColumn();
  if ($checkData == 0) {$insertData = "
          INSERT INTO products (name, category, price, stock) VALUES
          ('Two Faced Berry Macaroon', 'Fruity', 35000.00, 25),
            ('Lemonade Tea Macaroon', 'Citrus', 33000.00, 17),
            ('Salted Popcorn Macaroon', 'Savory', 40000.00, 15),
            ('Pineapple Coconut Macaroon', 'Tropical', 34000.00, 20),
            ('Green Apple Macaroon', 'Fruity', 36500.00, 14),
            ('Mystery Macaroon', 'Speciality', 57000.00, 5);
        ";
        $pdo->exec($insertData);
  }
  
} catch (PDOException $e) {
  die("Koneksi Database Gagal: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
