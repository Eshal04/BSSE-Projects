<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $desc = trim($_POST['desc']);

    if ($name && $price > 0 && $desc) {
        $stmt = $conn->prepare("INSERT INTO product (name, price, `desc`) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $desc]);
        $msg = '<div class="alert alert-success">✅ Product added!</div>';
    } else {
        $msg = '<div class="alert alert-danger">❌ All fields are required.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Mobile support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f2f6fc;
        }
        .form-container {
            max-width: 450px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 35px 25px;
        }
        h2 {
            text-align: center;
            color: #233b6e;
            margin-bottom: 25px;
        }
        .btn:hover {
            filter: brightness(0.93);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px) scale(1.04);
            transition: all 0.2s;
        }
        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }
            .btn {
                font-size: 0.9rem;
                min-width: 100px;
            }
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add Product</h2>
    <?= $msg ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label fw-semibold">Product Name</label>
            <input type="text" name="name" class="form-control" required style="border-radius: 8px;">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required style="border-radius: 8px;">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="desc" class="form-control" required style="border-radius: 8px; min-height: 80px;"></textarea>
        </div>
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <button type="submit" class="btn btn-success" style="font-weight: 500; border-radius: 8px;">Add</button>
            <a href="products.php" class="btn btn-secondary" style="font-weight: 500; border-radius: 8px;">Back</a>
        </div>
    </form>
</div>
</body>
</html>
