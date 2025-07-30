<?php
session_start();
require_once '../db/conn.php';
require_once '../include/_nav.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$total_products = $conn->query("SELECT COUNT(*) FROM product")->fetchColumn();
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important for mobile -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(135deg, #e3eaff 0%, #b3c6f7 100%); min-height:100vh;">
    <div class="container-fluid mt-5 px-3">
        <h2 class="text-center mb-4" style="color:#233b6e;">Welcome, Admin!</h2>

        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4 mb-3">
                <div class="card text-center shadow" style="background: linear-gradient(120deg, #233b6e 60%, #3e5ba9 100%); color:#fff;">
                    <div class="card-body">
                        <h4>Total Products</h4>
                        <p style="font-size:2rem; font-weight:bold;"><?= $total_products ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-4 mb-3">
                <div class="card text-center shadow" style="background: linear-gradient(120deg, #1e3799 60%, #4a69bd 100%); color:#fff;">
                    <div class="card-body">
                        <h4>Total Users</h4>
                        <p style="font-size:2rem; font-weight:bold;"><?= $total_users ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-4 mb-3">
                <div class="card text-center shadow" style="background: linear-gradient(120deg, #38ada9 60%, #78e08f 100%); color:#fff;">
                    <div class="card-body">
                        <h4>Total Orders</h4>
                        <p style="font-size:2rem; font-weight:bold;"><?= $total_orders ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center d-flex flex-wrap justify-content-center gap-2">
            <a href="manage_products.php" class="btn btn-primary" style="min-width:160px;">Manage Products</a>
            <a href="manage_users.php" class="btn btn-secondary" style="min-width:160px;">Manage Users</a>
            <a href="orders.php" class="btn btn-success" style="min-width:160px;">View Orders</a>
            <a href="users.php" class="btn btn-info" style="min-width:160px;">All Users</a>
            <a href="../index.php" class="btn btn-info" style="min-width:160px;">Back</a>
        </div>
    </div>

    <style>
        .card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
        }
        .btn {
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
            transition: all 0.18s;
        }
        .btn:hover {
            filter: brightness(0.93);
            transform: translateY(-2px) scale(1.04);
        }
    </style>
</body>
</html>
