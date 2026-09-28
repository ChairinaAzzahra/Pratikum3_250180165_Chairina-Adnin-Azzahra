<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$errors = [];
$name = '';
$category = 'Classic';
$price_raw = '';
$stock_raw = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? 'Classic');
    $price_raw = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $stock_raw = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_FLOAT);

    if (mb_strlen($name) < 3) {
        $errors['name'] = "Nama minimal 3 karakter.";
    }
    if ($price_raw === false || $price_raw <= 0) {
        $errors['price'] = "Harga harus lebih dari 0.";
    }
    if ($stock_raw === false || $stock_raw < 0) {
        $errors['stock'] = "Stok tidak boleh negatif.";
    }

    if (empty($errors)) {
        $checkStmt = $pdo->prepare("SELECT id FROM products WHERE name = :name");
        $checkStmt->execute(['name' => $name]);
        if ($checkStmt->fetch()){
            $errors['name'] = "Nama varian ini sudah digunakan oleh macaroon lain.";
        }
    }

    if (empty($errors)) {
        $insertStmt = $pdo->prepare("INSERT INTO products (name, category, price, stock) VALUES (:name, :category, :price, :stock)");
        $insertStmt->execute([
            'name' => $name,
            'category' => $category,
            'price' => $price_raw,
            'stock' => $stock_raw
        ]);

        header("Location: index.php?status=created");
        exit:
    }
}

$categories = ['Fruity', 'Classic', 'Savory', 'Chocolate', 'Nutty', 'Seasonl', 'Tropical', 'Speciality', 'Citrus', 'Matcha'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Macaroon - SweeTToothie Ateliar</title>
</head>
