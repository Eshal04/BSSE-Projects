<?php
// Dummy check for demo, replace with your real fetch logic
if (!isset($product)) {
    $product = ['name'=>'', 'price'=>'', 'desc'=>'', 'image'=>''];
}
if (!isset($msg)) $msg = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Mobile Scaling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #b3c6f7 0%, #e3eaff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .form-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
            padding: 32px 28px;
            max-width: 480px;
            margin: 50px auto;
        }
        h3 {
            color: #233b6e;
            text-align: center;
            margin-bottom: 22px;
            letter-spacing: 1px;
        }
        .btn:hover {
            filter: brightness(0.95);
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
            transform: translateY(-2px) scale(1.04);
            transition: all 0.2s;
        }
        @media (max-width: 600px) {
            .form-box {
                padding: 20px 15px;
                margin: 30px 10px;
            }
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" enctype="multipart/form-data" class="form-box">
        <h3>Edit Product</h3>
        <?= $msg ?>
        <div class="mb-3">
            <label style="font-weight:600; color:#233b6e;">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required style="border-radius:8px;">
        </div>
        <div class="mb-3">
            <label style="font-weight:600; color:#233b6e;">Price</label>
            <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required style="border-radius:8px;">
        </div>
        <div class="mb-3">
            <label style="font-weight:600; color:#233b6e;">Description</label>
            <textarea name="desc" class="form-control" style="border-radius:8px; min-height:80px;"><?= htmlspecialchars($product['desc']) ?></textarea>
        </div>
        <div class="mb-3">
            <label style="font-weight:600; color:#233b6e;">Image</label>
            <input type="file" name="image" class="form-control" style="border-radius:8px;">
            <?php if (!empty($product['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="80" class="mt-2" style="border-radius:8px; border:1px solid #b3c6f7;">
            <?php endif ?>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary" style="font-weight:600; border-radius:8px; min-width:120px; letter-spacing:1px;">Update Product</button>
            <a href="manage_products.php" class="btn btn-secondary" style="font-weight:600; border-radius:8px; min-width:100px; letter-spacing:1px;">Back</a>
        </div>
    </form>
</div>

</body>
</html>
