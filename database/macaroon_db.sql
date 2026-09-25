CREATE DATABASE IF NOT EXISTS macaroon_db;
USE macaroon_db;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(100) NOT NULL UNIQUE, 
  category VARCHAR(50) NOT NULL DEFAULT 'Classic', 
  price DECIMAL(12,2) NOT NULL, 
  stok INT NOT NULL DEFAULT 0, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, category, price, stock) VALUES
('Two Faced Berry Macaroon', 'Fruity', 35000.00, 25), 
('Lemonade Tea Macaroon', 'Citrus Tea', 33000.00, 17), 
('Salted Popcorn Macaroon', 'Savory Caramel', 40000.00, 15), 
('Pineapple Coconut Macaroon', 'Tropical', 34000.00, 20), 
('Green Apple Macaroon', 'Fruity Matcha', 36500.00, 14), 
('Mystery Macaroon', 'Limited Edition', 57000.00, 5);
