<?php
$host = 'localhost';
$dbname = 'sea';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // echo "Connected Successfully";  // ✅ Optional
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>


