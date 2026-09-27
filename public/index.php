<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$q = trim($_GET['q'] ?? '');
if (!empty($q)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :q OR category LIKE :q ORDER BY id DESC");
    $stmt->execute(['q' => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
}

$products = $stmt->fetchAll();

$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweeTToothie Ateliar - Product Manager</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1> SweeTToothie Ateliar</h1>
            <p>Manajemen Stok & Catalog Macaroon</p>
        </header>

        <?php if ($status === 'created'): ?>
            <div class="alert alert-success">Macaroon baru berhasil ditambahkan!</div>
        <?php elseif ($status === 'updated'): ?>                
            <div class="alert alert-success">Data macaroon berhasil diperbarui!</div>
        <?php elseif ($status === 'deleted'): ?>
            <div class="alert alert-success">Macaroon berhasil dihapus!</div>
        <?php endif; ?>

        <div class="toolbar">
            <form method="GET" action="index.php" class="search-form">
                <input type="text" name="q" placeholder="Cari varian atau kategori..."
                        value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
            <a href="create.php" class="btn btn-primary">+ Tambah Macaroon</a>
        </div>

        <div class="products-grid">
            <?php if (empty($products)): ?>
                <p style="text-align: center; width: 100%; color: #888;">Belum ada varian macaroon.</p>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="card">
                        <div>
                            <span class="card-tag"><?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?></span>
                            <h3 class="card-title"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="card-price">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                            <div class="card-stock">Stok Tersedia: <?= (int)$p['stock'] ?> pcs</div>
                        </div>

                        <div class="card-actions">
                            <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                            <form method="POST" action="delete.php" style="flex: 1;" onsubmit="return confirm('Yakin ingin menghapus macaroon ini?');">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <button type="submit" class="btn btn-delete" style="width: 100%;">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
