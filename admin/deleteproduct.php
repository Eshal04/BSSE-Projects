<?php
session_start();
require_once '../db/conn.php';

// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Check if a valid ID is passed and delete
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optionally: Check if the product exists before deleting
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$id]);
        // Optionally delete the image from uploads
        if (!empty($product['image']) && file_exists("../uploads/" . $product['image'])) {
            unlink("../uploads/" . $product['image']);
        }
    }
}

// Redirect back to product management
header('Location: manage_products.php');
exit;
