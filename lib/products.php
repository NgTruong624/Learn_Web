<?php
require_once 'db.php';

function getAllProducts($limit = null, $offset = 0) {
    global $pdo;
    $sql = "SELECT * FROM products ORDER BY id ASC"; // Thay đổi ở đây
    if ($limit !== null) {
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare($sql);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addProduct($name, $description, $price, $image_url, $type) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, type) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $description, $price, $image_url, $type]);
}

function updateProduct($id, $name, $description, $price, $image_url) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
    return $stmt->execute([$name, $description, $price, $image_url, $id]);
}

function deleteProduct($id) {
    global $pdo;
    try {
        $pdo->beginTransaction();

        // Lấy thông tin sản phẩm trước khi xóa
        $stmt = $pdo->prepare("SELECT image_url, type FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Xóa các bản ghi liên quan trong bảng order_items
            $stmt = $pdo->prepare("DELETE FROM order_items WHERE product_id = ?");
            $stmt->execute([$id]);

            // Xóa sản phẩm
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $result = $stmt->execute([$id]);

            if ($result) {
                // Xóa file ảnh
                $image_dir = $product['type'] === 'club' ? 'Club' : 'Nation';
                $image_path = "../images/{$image_dir}/" . basename($product['image_url']);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $pdo->commit();

        // Gọi stored procedure để sắp xếp lại ID và reset AUTO_INCREMENT
        $stmt = $pdo->prepare("CALL ReorderProductIDs()");
        $stmt->execute();

        return $result ?? false;
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Error deleting product: " . $e->getMessage());
        return false;
    }
}

function getOutstandingProducts($limit = 4) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id BETWEEN 1 AND ? ORDER BY id");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getTotalProductCount() {
    global $pdo;
    $sql = "SELECT COUNT(*) as total FROM products";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}