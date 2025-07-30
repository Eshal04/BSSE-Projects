<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Success message
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $msg = '<div class="alert alert-success">Product deleted successfully!</div>';
}

// Fetch products
$products = $conn->query("SELECT * FROM product ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Mobile scaling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f2f6fc;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .btn:hover {
            filter: brightness(0.95);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-2px) scale(1.03);
            transition: all 0.2s ease;
        }
        img {
            border-radius: 6px;
        }
        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 13px;
                vertical-align: middle;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4">All Products</h2>

    <?= $msg ?>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="add_product.php" class="btn btn-success">Add New Product</a>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Image</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>$<?= number_format($p['price'], 2) ?></td>
                    <td><?= htmlspecialchars($p['desc']) ?></td>
                    <td>
                        <?php
                            $imgPath = "../uploads/" . $p['img'];
                            $finalImg = (!empty($p['img']) && file_exists($imgPath)) ? $imgPath : "../uploads/default.jpg";
                        ?>
                        <img src="<?= $finalImg ?>" width="60" height="60" style="object-fit:cover;">
                    </td>
                    <td>
                        <a href="product_edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="product_delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
