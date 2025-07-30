<?php
session_start();
require_once '../db/conn.php';

// ✅ Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// ✅ Fetch only users, not admins
$users = $conn->query("SELECT id, fullname, email, role, status FROM users WHERE role='user' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background:#f2f6fc;">

<div class="container mt-5">
    <h2 class="mb-3">Manage Users</h2>

    <!-- ✅ Alert Messages -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'blocked'): ?>
        <div class="alert alert-warning">User blocked successfully!</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success">User deleted successfully.</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'unblocked'): ?>
        <div class="alert alert-success">User unblocked successfully.</div>
    <?php endif; ?>

    

    <!-- ✅ User Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="min-width:150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['fullname']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td><?= htmlspecialchars($u['status']) ?></td>
                    <td>
                        <?php if ($u['status'] === 'active'): ?>
                            <a href="user_block.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Block</a>
                        <?php else: ?>
                            <a href="user_unblock.php?id=<?= $u['id'] ?>" class="btn btn-success btn-sm">Unblock</a>
                        <?php endif; ?>
                        <a href="user_delete.php?id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
                        
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <a href="dashboard.php" class="btn btn-secondary mb-3 float-end">Back to Dashboard</a>
        </table>
    </div>
</div>

</body>
</html>
