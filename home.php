<?php
session_start();
require_once 'lib/products.php';
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="container">
        <div class="head">
            <a href="home.php">
                <img src="images/img/logo.jpg" style="height: 100px; width: 100px;">
            </a>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Tìm kiếm" id="search-input">
                <button class="search-button" onclick="search_Product();">
                    <img src="images/img/211817_search_strong_icon.png" alt="Search">
                </button>
            </div>
                <div class="info">
                    <ul class="list">
                        <a href="home.php"><li>Home</li></a> 
                        <a href="about.html"><li>About</li></a>
                        <a href="blog.html"><li>Blog</li></a>
                        <a href="contact.html"><li>Contact</li></a>
                    </ul>
                </div>
                <div class="more">
                    <select name="" id="moreoption">
                        <option value="" >Chọn sản phẩm</option>
                        <option value="homeclb.php" >Áo CLB</option>
                        <option value="homedtqg.php" >Áo ĐTQG</option>
                        <option value="shoes.php" >Giày</option>
                    </select>
                </div>
                <div class="login">
                    <a href="cart.php" title="GIỎ HÀNG">
                        <img src="images/img/shop.png" >
                    </a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-info">
                            <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <a href="logout.php" class="logout-btn" title="ĐĂNG XUẤT">Đăng xuất</a>
                            <a href="#" title="THÔNG TIN TÀI KHOẢN">
                                <img src="images/img/login.png" alt="User Profile">
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" title="ĐĂNG NHẬP">
                            <img src="images/img/login.png" alt="Login">
                        </a>
                    <?php endif; ?>
                </div>
        </div>

        <div id="abc">
        <div class="nav" id="nav">
            <img src="images/img/banner.png" alt="Banner 1">

            <img src="images/img/banner-2.jpg" alt="Banner 2">
        </div>
    <div class="main">
        <h3>SẢN PHẨM NỔI BẬT</h3>
        <div id="outstanding">
        <ul>
        <?php
            $outstandingProducts = getOutstandingProducts(4);
            foreach ($outstandingProducts as $product) {
                $productType = $product['type'] === 'club' ? 'Club' : 'Nation';
                ?>
                    <li>
                        <div class='product-item'>
                            <div class='product-top'>
                                <a href='productdetail.php?productId=<?php echo $product['id']; ?>' class='product-thumb'>
                                    <img src='<?php echo $product['image_url']; ?>' alt='<?php echo $product['name']; ?>'>
                                </a>
                            </div>
                            <div class='product-info'>
                                <a href='productdetail.php?productId=<?php echo $product['id']; ?>' class='product-cat'><?php echo $productType; ?></a>
                                <a href='productdetail.php?productId=<?php echo $product['id']; ?>' class='product-name'><?php echo $product['name']; ?></a>
                                <div class='product-price'><?php echo $product['price']; ?> vnđ</div>
                            </div>
                        </div>
                        <div class='buy-now'>
                            <a href='productdetail.php?productId=<?php echo $product['id']; ?>'>Xem chi tiết</a>
                        </div>
                    </li>
                <?php
            }                                                                                                                  
        ?>
        </ul>
    </div>
</div>
        <div class="contact">
            <div class="image-section">
                <img src="images/img/Ronaldo_sporting.jpg" >
                <img src="images/img/ronaldoMu1.jpg" >
                <img src="images/img/RonaldoReal.jpg" >
                <img src="images/img/RonaldoJuventus.jpg" >
                <img src="images/img/RonaldoMu2.jpg" >
                <img src="images/img/ronaldoalnassr.jpg" >
            </div>
            <div class="text-section">
                <h2>Chuyên cung cấp áo bóng đá và giày chất lượng tốt giao hàng nhanh</h2>
                <a href="contact.html" id="buy">Liên hệ ngay</a>
            </div>
        </div>
        </div>
        <footer>
            <div class="address">
                <div class="a">
                    <h1 style="color: yellow;">AOBONGDA.VN</h1>
                    <p><span style="font-weight: bold;">Cơ sở 1</span>: 02 Võ Oanh - Phường 25 - Bình Thạnh - TP Hồ Chí Minh</p>
                    <p>Hotline : <span style="color: yellow;">028 3512 8986</span></p>
                    <p><span style="font-weight: bold;">Cơ sở 2 : </span>17 Đ. 12, P. Bình An, Quận 2, Hồ Chí Minh </p>
                    <p>Hotline : <span style="color: yellow;"> 0283 8992862</span></p>
                    <p>Email : <span style="color: yellow;">ut-hcmc@ut.edu.vn</span></p>
                </div>
                <div class="product">
                    <h4> <span style="font-weight: bold; color: yellow;">SẢN PHẨM</span></h4>
                    <h4><a href="">ÁO CÂU LẠC BỘ</a></h4>
                    <h4><a href="">ÁO ĐỘI TUYỂN QUỐC GIA</a></h4>
                    <h4><a href="">GIÀY BÓNG ĐÁ</a></h4>
                </div>
                <div class="policy">
                    <h4><span style="color: yellow;">CHÍNH SÁCH</span></h4>
                    <h4><a href="">GIỚI THIỆU</a></h4>
                    <h4><a href="">HƯỚNG DẪN ĐẶT HÀNG</a></h4>
                    <h4><a href="">HƯỚNG DẪN THANH TOÁN</a></h4>
                    <h4><a href="">CHÍNH SÁCH BẢO HÀNH</a></h4>
                    <h4><a href="">CHÍNH SÁCH ĐỔI TRẢ</a></h4>
                    <h4><a href="">CHÍNH SÁCH GIAO NHẬN</a></h4>
                    <h4><a href="">CHÍNH SÁCH BẢO MẬT</a></h4>
                </div>
                <div class="connect">
                    <h4><span style="color: yellow;">KẾT NỐI VỚI CHÚNG TÔI</span></h4>
                    <div class="icon">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/TruongDHGiaothongvantaiTPHCM" target="_blank">
                                    <img src="images/img/facebook.png">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/c/TR%C6%AF%E1%BB%9CNG%C4%90HGIAOTH%C3%94NGV%E1%BA%ACNT%E1%BA%A2ITPHCM" target="_blank">
                                    <img src="images/img/youtube.png">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/messages/t/917252485064205?locale=vi_VN" target="_blank">
                                    <img src="images/img/mess.png">
                                </a>
                            </li>
                            <li>
                                <a href="https://shopee.vn/%C3%81o-%C4%90%C3%A1-B%C3%B3ng-%C4%90%E1%BB%93-%C4%90%C3%A1-Banh-M%E1%BB%9Bi-Nh%E1%BA%A5t-2024-
                                        V%E1%BA%A3i-Thun-L%E1%BA%A1nh-Cao-C%E1%BA%A5p-BONGDAXP-S1-i.162160612.6233765457?
                                        sp_atk=a0f0a464-8fb6-499f-962f-994459d493ae&xptdk=a0f0a464-8fb6-499f-962f-994459d493ae" target="_blank">
                                    <img src="images/img/shop.png">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4318.462043943294!2d106.71442560774074!3d10.804649740182606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!
                                1s0x3175293dceb22197%3A0x755bb0f39a48d4a6!2zVHLGsOG7nW5nIMSQ4bqhaSBI4buNYyBHaWFvIFRow7RuZyBW4bqtbiBU4bqjaSBUaMOgbmggUG
                                jhu5EgSOG7kyBDaMOtIE1pbmggLSBDxqEgc-G7nyAx!5e0!3m2!1svi!2s!4v1725381456051!5m2!1svi!2s
                                " width="auto" height="auto" style="border:0;" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </footer>
    </div>  
    <script src="js/script.js"></script>
    <script src="js/homesearch.js"></script>
</body>
</html>
</html>