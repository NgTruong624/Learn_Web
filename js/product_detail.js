       
document.getElementById('moreoption').addEventListener('change', function(){
    var url = this.value;
    if(url){
        window.location.href=url;
    }
});

       
       // Lấy productId từ URL
       const urlParams = new URLSearchParams(window.location.search);
       const productId = urlParams.get('productId');
   
       document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('productId');
    
        if (productId) {
            fetch(`get_product_details.php?productId=${productId}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('product-name').textContent = product.name;
                    document.getElementById('product-image').src = product.image_url;
                    document.getElementById('product-image').alt = product.name;
                    document.getElementById('product-price').textContent = `${parseInt(product.price).toLocaleString('vi-VN')} VNĐ`;
                    document.getElementById('product-description').textContent = product.description;
                    window.currentProduct = product;
                })
                .catch(error => console.error('Error:', error));
        }
    });

           function addToCart() {
               if (window.currentProduct) {
                   fetch('add_to_cart.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       body: JSON.stringify({
                           productId: window.currentProduct.id,
                           quantity: 1
                       }),
                   })
                   .then(response => response.json())
                   .then(data => {
                       if (data.success) {
                           alert(window.currentProduct.name + " đã được thêm vào giỏ hàng!");
                       } else {
                           alert("Có lỗi xảy ra khi thêm vào giỏ hàng.");
                       }
                   })
                   .catch(error => {
                       console.error('Error:', error);
                       alert("Có lỗi xảy ra khi thêm vào giỏ hàng.");
                   });
               } else {
                   alert("Không có sản phẩm để thêm vào giỏ hàng");
               }
           }

           function buyNow() {
               addToCart();
               window.location.href = "checkout.php";
           }