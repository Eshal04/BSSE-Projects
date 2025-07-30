<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $oid = intval($_POST['order_id']);
    $status = $_POST['status'];
    $allowed = ['Pending', 'Completed', 'Cancelled'];
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->execute([$status, $oid]);
        $msg = '<div class="alert alert-success mb-3">Order status updated!</div>';
    }
}

$orders = $conn->query("SELECT o.id, o.user_id, o.product_id, o.quantity, o.status, u.fullname, p.name AS product_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN product p ON o.product_id = p.id
    ORDER BY o.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Responsive support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e3eaff 0%, #b3c6f7 100%);
            min-height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
            padding: 35px 25px;
            margin-top: 30px;
        }
        h2 {
            color: #233b6e;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 1px;
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
            .btn, .form-select {
                font-size: 0.9rem;
            }
            .table th, .table td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>All Orders</h2>
    <?= $msg ?>

    <div class="table-responsive">
        <table class="table table-bordered mt-3" style="background:#f8faff;">
            <thead style="background:#233b6e; color:#fff;">
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['fullname']) ?></td>
                    <td><?= htmlspecialchars($o['product_name']) ?></td>
                    <td><?= $o['quantity'] ?></td>
                    <td>
                        <form method="post" class="d-flex align-items-center flex-wrap gap-2">
                            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                            <select name="status" class="form-select form-select-sm" style="min-width:110px; border-radius:6px;">
                                <option <?= $o['status']=='Pending'?'selected':'' ?>>Pending</option>
                                <option <?= $o['status']=='Completed'?'selected':'' ?>>Completed</option>
                                <option <?= $o['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm" style="font-weight:500; border-radius:6px;">Update</button>
                        </form>
                    </td>
                    <td><!-- Reserved for future actions --></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary" style="font-weight:500; border-radius:8px; min-width:160px;">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
