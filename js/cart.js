document.getElementById('moreoption').addEventListener('change', function(){
    var url = this.value;
    if(url){
        window.location.href=url;
    }
});

function removeFromCart(productId) {
    fetch('remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Xóa phần tử khỏi DOM thay vì tải lại trang
            const cartItem = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
            if (cartItem) {
                cartItem.remove();
            }
            // Cập nhật tổng giá
            updateTotalPrice();
        } else {
            alert('Có lỗi xảy ra: ' + data.message);
        }
    });
}

function updateTotalPrice() {
    // Gọi API để lấy tổng giá mới
    fetch('get_cart_total.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('total-price').textContent = 'Tổng giá: ' + data.total + ' VND';
        }
    });
}

function checkout(isCartEmpty) {
    if (isCartEmpty) {
        alert('Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
    } else {
        window.location.href = 'checkout.php';
    }
}