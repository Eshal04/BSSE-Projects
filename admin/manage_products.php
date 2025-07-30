<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
if (isset($_GET['msg']) && $_GET['msg'] === 'updated') {
    echo '<div class="alert alert-success">Product updated successfully!</div>';
}
$products = $conn->query("SELECT * FROM product")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Mobile responsiveness -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #233b6e 0%, #3e5ba9 100%);
            min-height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
            padding: 35px 25px;
            margin-top: 30px;
        }
        .btn:hover {
            filter: brightness(0.93);
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
            transform: translateY(-2px) scale(1.04);
            transition: all 0.2s;
        }
        table th, table td {
            vertical-align: middle !important;
        }
        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }
            .table-responsive {
                overflow-x: auto;
            }
            .btn {
                font-size: 0.9rem;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center" style="color:#233b6e; margin-bottom: 30px; letter-spacing:1px;">Manage Products</h2>

    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
        <a href="add_product.php" class="btn btn-success" style="font-weight:500; border-radius:8px; min-width:130px;">Add Product</a>
        <a href="dashboard.php" class="btn btn-secondary" style="font-weight:500; border-radius:8px; min-width:160px;">Back to Dashboard</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mt-3" style="background:#f8faff; border-radius:10px;">
            <thead style="background:#233b6e; color:#fff;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th style="min-width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= $p['price'] ?></td>
                        <td><?= htmlspecialchars($p['desc']) ?></td>
                        <td>
                            <a href="editproduct.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm mb-1" style="font-weight:500; border-radius:6px;">Edit</a>
                            <a href="deleteproduct.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm mb-1" style="font-weight:500; border-radius:6px;" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
