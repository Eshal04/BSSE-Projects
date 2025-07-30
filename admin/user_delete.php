<?php
session_start();
require_once '../db/conn.php';

// ✅ Allow only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// ✅ Get user ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ✅ Delete only if ID is valid and role is 'user'
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'user'");
    $stmt->execute([$id]);
}

// ✅ Redirect after deletion
header('Location: users.php?msg=deleted');
exit;
