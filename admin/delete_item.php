<?php
require_once '../lib/db.php';
require_once '../lib/products.php';

// Kiểm tra xem có phải là yêu cầu POST và có ID sản phẩm không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (deleteProduct($id)) {
        // Gọi stored procedure để sắp xếp lại ID
        global $pdo;
        $stmt = $pdo->prepare("CALL ReorderProductIDs()");
        $stmt->execute();

        header("Location: manage_items.php?success=1");
        exit();
    } else {
        header("Location: manage_items.php?error=1");
        exit();
    }
} else {
    // Nếu không phải là yêu cầu POST hoặc không có ID, chuyển hướng về trang quản lý sản phẩm
    header('Location: manage_items.php');
    exit;
}
