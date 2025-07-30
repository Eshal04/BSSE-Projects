<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Mobile responsiveness -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f2f6fc;
        }
        .container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 35px 25px;
            margin-top: 30px;
        }
        h2 {
            text-align: center;
            color: #233b6e;
            margin-bottom: 30px;
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
                min-width: 130px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Users</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['fullname']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary" style="font-weight:500; border-radius:8px;">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
