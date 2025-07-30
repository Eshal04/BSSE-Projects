<?php
session_start();
require_once '../db/conn.php';

// ✅ Only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// ✅ Validate user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_users.php');
    exit;
}

$user_id = intval($_GET['id']);

// ✅ Update status to 'blocked'
$stmt = $conn->prepare("UPDATE users SET status = 'blocked' WHERE id = ? AND role = 'user'");
$stmt->execute([$user_id]);

// ✅ Redirect back with success message
header("Location: manage_users.php?msg=blocked");
exit;
