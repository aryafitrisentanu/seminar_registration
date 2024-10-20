<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

// Soft delete dengan mengubah is_deleted menjadi true
$stmt = $conn->prepare("UPDATE registration SET is_deleted = 1 WHERE id = ?");
$stmt->execute([$id]);

header('Location: manage_registration.php');
?>
