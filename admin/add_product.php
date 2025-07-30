<?php
session_start();
require_once '../db/conn.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $desc  = trim($_POST['desc']);

    // ✅ Image upload
    $img_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['image']['name']);
        $img_tmp  = $_FILES['image']['tmp_name'];
        $upload_dir = '../uploads/';
        $img_path = $img_name; // ✅ only store filename

        move_uploaded_file($img_tmp, $upload_dir . $img_name);
    }

    // ✅ Insert into database
    $stmt = $conn->prepare("INSERT INTO product (name, price, `desc`, img) VALUES (?, ?, ?, ?)");
    $success = $stmt->execute([$name, $price, $desc, $img_path]);

    if ($success) {
        $msg = "<div class='alert alert-success text-center'>✅ Product added successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger text-center'>❌ Failed to add product.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #233b6e 0%, #3e5ba9 100%);
            min-height: 100vh;
        }
        .form-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
            padding: 35px 20px;
            margin: 30px auto;
        }
        .btn:hover {
            filter: brightness(0.93);
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
            transform: translateY(-2px) scale(1.04);
            transition: all 0.2s;
        }
        @media (max-width: 576px) {
            .form-container { padding: 25px 15px; }
            h2 { font-size: 1.5rem; }
            .btn { font-size: 0.9rem; min-width: 90px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container" style="max-width:480px;">
        <h2 style="color:#233b6e; text-align:center; margin-bottom:30px;">Add Product</h2>
        <?= $msg ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required style="border-radius:8px;">
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control" step="0.01" required style="border-radius:8px;">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="desc" class="form-control" required style="border-radius:8px; min-height:80px;"></textarea>
            </div>
            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control" style="border-radius:8px;" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success" style="min-width:100px;">Add</button>
                <a href="products.php" class="btn btn-secondary" style="min-width:100px;">Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
