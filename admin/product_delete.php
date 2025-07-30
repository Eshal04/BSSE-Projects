<?php
session_start();
require_once '../db/conn.php';

// Allow only admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    header('Location: products.php?msg=deleted');
    exit;
}

// Get and validate product ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirect after deletion
header('Location: products.php?msg=deleted');
exit;
