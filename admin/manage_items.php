<?php include 'admin_header.php'; ?>
            <div class="admin-content-main">
                <div class="admin-content-main-title"></div>

<?php
require_once '../lib/db.php';
require_once '../lib/products.php';

// Thêm logic phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 5; // Số sản phẩm trên mỗi trang
$offset = ($page - 1) * $itemsPerPage;

// Cập nhật hàm getAllProducts để hỗ trợ phân trang
$products = getAllProducts($itemsPerPage, $offset);
$totalProducts = getTotalProductCount(); // Thêm hàm này vào lib/products.php
$totalPages = ceil($totalProducts / $itemsPerPage);
?>
<div class="admin-content-main">
    <div class="admin-content-main-title">
        <h1>Danh sách sản phẩm</h1>
    </div>
    <div class="admin-content-main-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Ngày đăng</th> <!-- Đổi tên cột -->
                    <th class="action-column">Tùy chỉnh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td>
                        <?php
                        $image_dir = $product['type'] === 'club' ? 'Club' : 'Nation';
                        $image_path = "../images/{$image_dir}/" . basename($product['image_url']);
                        ?>
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($product['updated_at'] ?? $product['created_at'])); ?></td>
                    <td class="action-column">
                        <a href="../admin/edit_item.php?id=<?php echo urlencode($product['id']); ?>" class="edit-btn">Sửa</a>
                        <form method="POST" action="../admin/delete_item.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Thêm phân trang -->
        <div class="pagination">
            <?php
            $range = 2; // Số trang hiển thị ở mỗi bên của trang hiện tại
            ?>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">&laquo; Trước</a>
            <?php endif; ?>
            
            <?php for ($i = max(1, $page - $range); $i <= min($totalPages, $page + $range); $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php echo ($page == $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">Sau &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'admin_footer.php'; ?>