<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: manage_products.php');
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: manage_products.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $desc = trim($_POST['desc'] ?? '');

    $imgName = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imgName);
    }

    if ($name && $price) {
        $stmt = $conn->prepare("UPDATE product SET name=?, price=?, `desc`=?, image=? WHERE id=?");
        $stmt->execute([$name, $price, $desc, $imgName, $id]);
        header('Location: manage_products.php?msg=updated');
        exit;
    } else {
        $error = "Name and Price required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- For responsiveness -->
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
            padding: 35px 25px;
            margin: 30px auto;
        }
        .btn:hover {
            filter: brightness(0.93);
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
            transform: translateY(-2px) scale(1.04);
            transition: all 0.2s;
        }
        @media (max-width: 576px) {
            .form-container {
                padding: 25px 15px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .btn {
                font-size: 0.9rem;
                min-width: 90px;
            }
            img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container" style="max-width:480px;">
        <h2 style="color:#233b6e; text-align:center; margin-bottom:30px; letter-spacing:1px;">Edit Product</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label style="font-weight:500;">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required style="border-radius:8px;">
            </div>
            <div class="mb-3">
                <label style="font-weight:500;">Price</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required style="border-radius:8px;">
            </div>
            <div class="mb-3">
                <label style="font-weight:500;">Description</label>
                <textarea name="desc" class="form-control" style="border-radius:8px; min-height:80px;"><?= htmlspecialchars($product['desc']) ?></textarea>
            </div>
            <div class="mb-3">
                <label style="font-weight:500;">Image</label>
                <input type="file" name="image" class="form-control" style="border-radius:8px;">
                <?php if (!empty($product['image'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="80" class="mt-2" style="border-radius:8px; border:1px solid #ccc;">
                <?php endif ?>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <button type="submit" class="btn btn-primary" style="font-weight:500; border-radius:8px; min-width:120px;">Update</button>
                <a href="manage_products.php" class="btn btn-secondary" style="font-weight:500; border-radius:8px; min-width:100px;">Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
