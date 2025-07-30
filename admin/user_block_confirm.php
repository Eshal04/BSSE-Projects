<?php
session_start();
require_once '../db/conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

// Fetch user name for confirmation
$stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ? AND role = 'user'");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: users.php');
    exit;
}

// Handle confirmation POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->prepare("UPDATE users SET status = 'blocked' WHERE id = ?")->execute([$id]);
    header('Location: users.php?msg=blocked');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Block User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Mobile -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background: #f2f6fc;">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 text-center" style="max-width: 420px; width: 100%;">
        <h4 class="text-danger mb-3">Confirm Block</h4>
        <p>Are you sure you want to <strong>block</strong> user <br><strong><?= htmlspecialchars($user['fullname']) ?></strong>?</p>
        <form method="post">
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-danger">Yes, Block</button>
                <a href="users.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
