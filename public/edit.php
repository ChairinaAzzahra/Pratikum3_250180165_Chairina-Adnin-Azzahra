<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
  header("location: index.php");
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
  header("Location: index.php");
  exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST[''category] ?? 'Classic');
    $price_raw = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $stock_raw = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

    if (mb_strlen($name) < 3) {
        $errors['name'] = "Nama minimal 3 karakter.";
    }
    if ($price_raw === false || $price_raw <= 0) {
        $errors['price'] = "Harga harus > 0.";
    }
    if ($stock_raw === false || $stock_raw < 0) {
        $errors['stock'] = "Stok tidak boleh negatif.";
    }

    if (empty($errors)) {
        $checkStmt = $pdo->prepare("SELECT id FROM products WHERE name = :name AND id != :id");
        $checkStmt->execute(['name' => $name, 'id' => $id]);
        if ($checkStmt->fetch()) {
          $errors['name'] = "Nama varian ini sudah digunakan oleh macaroon lain.";
        }
    }
    
    if (empty($errors)) {
        $updateStmt = $pdo->prepare("UPDATE products SET name = :name, category = :category, price = :price, stock = :stock WHERE id = :id");
        $updateStmt->execute([
            'name' => $name,
            'category' => $category,
            'price' => $price_raw,
            'stock' => $stock_raw,
            'id' => $id
        ]);

        header("Location: index.php?status=updated");
        exit;
    }
} else {
    $name = $product['name'];
    $category = $product['category'];
    $price_raw = $product['price'];
    $stock_raw = $product['stock'];
}

$categories = ['Fruity', 'Classic', 'Savory', 'Chocolate', 'Nutty', 'Seasonal', 'Tropical', 'Speciality', 'Citrus', 'Matcha']

if (!empty($category) && !in_array($category, $categories)) {
    $categories[] = $category;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset+"UTF-8">
    <title>Edit Macaroon - SweeTToothie Atelier </title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Varian Macaroon</h1>
            <p>Perbarui informasi rasa, harga, atau stok macaroon</p>
        </header>

        <div class="form-card">
            <form method="POST" action="edit.php?id=<?= $id ?>">
              <!-- Field Nama-->
              <div class="form-group">
                  <label for="name">Nama Macaroon</label>
                  <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required>
                  <?php if (isset($errors['name'])): ?>
                      <div class="error-text"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></div>
                  <?php endif; ?>
              </div>

              <!-- Field Kategori /  Rasa-->
              <div class="form-group">
                  <label for="category">Kategori / Rasa</label>
                  <select id="category" name="category">
                      <?php foreach ($categories as $cat): ?>
                          <option value="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>"> <?= ($category === $cat) ? 'selected' : '' ?>>
                              <?= htmmlspecialchars($cat. ENT_QUOTES, 'UTF-8')?>
                          </option>
                      <?php endforeach; ?>
                  </select>
                  <?php if (isset($erroes['category'])): ?>
                      <div class="error-text"><?= htmlspecialchars($errors[''category], ENT_QUOTES, 'UTF-8') ?></div>
              </div>

              <!-- Field Harga-->
              <div class="form-group">
    </div>
</body>
