<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
<link href="images/logoicon.ico" rel="shortcut icon"/>  
<title>台南下營鋐茶鵝</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<!-- 有綁定其他樣式，因此先取消使用原先樣式表 -->
<!-- <link rel="stylesheet" href="css/shoppage.css" /> -->
<!-- 新商品頁樣式表，有要新增的寫在這 -->
<link rel="stylesheet" href="css/shoppage-new.css">
<link rel="stylesheet" href="css/main.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/jquery-3.3.1.js" type="text/javascript" charset="utf-8"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Yusei+Magic&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="../"></script>
<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">
<!-- Wrapper -->
<div id="wrapper">
	
	<!--navbar區塊-->
	<nav>
		<div class="navbar navbar-expand-lg p-3" style="background-color: #fede00">
			<div class="container">
				<a href="index_nologin.html"><img style="width: 280px;" src="images/logo.png"></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
					<span class="navbar-toggler-icon"></span>
				</button>
	
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item"><a href="about_nologin.html" class="text-black">關於我們</a></li>
						<!-- <li><a href="#">商品總覽</a></li> -->
						<li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black">線上訂購</a></li>
						<li class="nav-item"><a href="common-quest_nologin.html" class="text-black">常見問題</a></li>
						<li class="nav-item"><a href="contact_nologin.html" class="text-black">聯絡我們</a></li>
						<li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#login-modal" class="text-black">會員登入</a></li>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
							  <a href="#" id="cartButton" class="d-flex align-items-center text-black">
								<img src="images/shopping-cart.png" width="20" height="20" class="me-2">購物車
								<span id="cartCount" class="cart-count"></span>
							  </a>
							</li>
						  </ul>
						  </div>
						  </div>
						  </div>
						  </nav>
						  
						  <!-- 購物車彈出視窗 -->
						  <div id="cartModal" class="modal" tabindex="-1">
							<div class="modal-dialog">
							  <div class="modal-content">
								<div class="modal-header">
								  <h5 class="modal-title">購物車</h5>
								  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeCartModal()"></button>
								</div>
								<div class="modal-body">
								  <p>
									<div id="cart">
									<div id="cart-items"></div>
								    </div>
								  </p>
                                  <p>
                                    <span id="totalPriceLabel">總金額為：</span>
                                    <span id="totalPriceValue">0元</span>
                                 </p>
								</div>
								<div class="modal-footer">
                  <button class="btn btn-outline-warning" onclick="clearCart()">清空購物車</button>
									<button class="btn btn-outline-warning" onclick="writeToDatabase()">前往結帳</button>
								</div>
							  </div>
							</div>
						  </div>


<!-- 每頁開頭頁籤區塊 -->
<div id="logo" class="container ">
    <i class="fa-solid fa-house ms-2" style="color: #8f8f8f; "></i>&nbsp;<a href="index_nologin.html">首頁</a> — <a href="shoppage.html">線上訂購</a>
  </div>
  
  <!-- 商品頁 -->
  <div class="container justify-content-between">
    <div class="row">
      <!-- 左側固定欄位 -->
      <div class="col-md-2 mt-5">
        <div class="list-group" >
          <a href="index_nologin.html" class="list-group-item list-group-item-action border-0 border-bottom">首頁</a>
          <a href="about_nologin.html" class="list-group-item list-group-item-action border-0 border-bottom">關於我們</a>
          <a href="common-quest_nologin.html" class="list-group-item list-group-item-action border-0 border-bottom">常見問題</a>
          <a href="contact_nologin.html" class="list-group-item list-group-item-action border-0 border-bottom">聯絡我們</a>
        </div>
      </div>
      <!-- 右側商品列表 -->
      <div class="container col-md-10 mt-5 mb-5">
 
            <div class="section-heading">所有商品</div>
            <!-- 商品項目 -->
            <div class="row justify-content-evenly">

                <!-- 每項商品 -->
                <?php
                // 設定資料庫連線參數
                $host = '192.168.2.200';
                $user = 'hongteag_goose';
                $password = 'ab7777xy';
                $dbname = 'hongteag_goose';

                // 建立資料庫連線
                $conn = new mysqli($host, $user, $password, $dbname);
                $conn->set_charset("utf8");
                // 檢查連線是否成功
                if ($conn->connect_error) {
                    die("連線失敗: " . $conn->connect_error);
                }

                // 執行 SQL 查詢語句
                $sql = "SELECT Product_image, Product_name, Product_price, Product_description, Product_ID FROM product";
                $result = $conn->query($sql);

                // 處理每一筆商品資料
                while ($row = $result->fetch_assoc()) {
                    $imageSrc = $row['Product_image'];
                    $productName = $row['Product_name'];
                    $productPrice = $row['Product_price'];
                    $productDescription = $row['Product_description'];
                    $productId = $row['Product_ID'];

                    // 動態生成唯一的數量輸入框ID和按鈕ID
                    $quantityInputId = 'quantity-input' . $productId;
                    $decreaseButtonId = 'decrease-button' . $productId;
                    $increaseButtonId = 'increase-button' . $productId;
                ?>
                    <!-- quantity-input<?php echo $productId; ?> -->
                    <div class="card col-12 col-md-6 col-lg-4 col-xl-3 p-2 m-3">
                        <a href="#" class="card-header">
                            <img src="<?php echo $imageSrc; ?>" class="card-img-top product-image" alt="Product <?php echo $productId; ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-baseline product-name" style="font-weight: bolder;">
                                <?php echo $productName; ?>
                                <span class="product-price text-end fs-6 text-center" style="color: #f26649; font-weight: bold; ">NT$ <?php echo $productPrice; ?></span>
                            </h5>
                            <p class="card-text product-description"><?php echo $productDescription; ?></p>
                            <div class="container border rounded d-flex justify-content-evenly align-content-center">
                                <!-- 按鈕等邏輯的部分保持不變 -->
                                <button class="btn" id="<?php echo $decreaseButtonId; ?>" type="button" onclick="decreaseQuantity('<?php echo $quantityInputId; ?>');"><i class="fa-solid fa-minus" style="color: #FEC107;"></i></button>
                                <input class="form-control product-value text-center mx-3" readonly id="<?php echo $quantityInputId; ?>" type="number" value="1" style="border:transparent; font-weight: bolder;">
                                <button class="btn" id="<?php echo $increaseButtonId; ?>" type="button" onclick="increaseQuantity('<?php echo $quantityInputId; ?>');"><i class="fa-solid fa-plus" style="color: #FEC107;"></i></button>
                            </div>
                            <div class="container d-flex justify-content-center mt-3">
                                <!-- 按鈕等邏輯的部分保持不變 -->
                                <button class="btn btn-warning" type="button" style="width: 80%; font-weight: bolder; font-size: 15px;" onclick="addToCart('<?php echo $productName; ?>', '<?php echo $quantityInputId; ?>', '<?php echo $productPrice; ?>')">
                                <i class="fa-solid fa-cart-shopping mt-2 me-2" style="color: #ffffff; "></i>加入購物車</button>
                            </div>
                        </div>
                    </div>
                <?php
                }

                // 關閉資料庫連線
                $conn->close();
                ?>
                <!-- 其他品項待新增 -->

            </div>
        </div>
    </div>
</div>


            <!-- 其他品項待新增 -->
                                          
        </div>
      </div>
    </div>
  </div>
									
  <script>
							//預設關閉購物車
							window.addEventListener("load", function() {
								document.getElementById("cartModal").style.display = "none";
							});

							var cartCount = 0; // Initialize the cart count to 0

// 開啟購物車彈出視窗
function openCartModal() {
    // Display the shopping cart modal
    document.getElementById("cartModal").style.display = "block";

    // Display the added items and their quantities
    var cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = ""; // Clear previous contents

    // Get all the cart items and their quantities from local storage
    var cartItems = JSON.parse(localStorage.getItem("cartItems"));

    // Check if cartItems is null or undefined
    if (!cartItems || cartItems.length === 0) {
        console.log("No items in the cart.");
        return;
    }

    // Loop through each item in the cart and add it to the cart modal
    for (var i = 0; i < cartItems.length; i++) {
        var cartData = cartItems[i];
        var itemName = cartData.productName;
        var quantity = cartData.quantity;
        var itemPrice = cartData.productPrice;
        var totalPrice = itemPrice * quantity;

        var cartItemContainer = document.createElement("div");
        cartItemContainer.className = "cart-item";

        var itemNameElement = document.createElement("span");
        itemNameElement.innerText = itemName;
        cartItemContainer.appendChild(itemNameElement);

        var quantityElement = document.createElement("span");
        quantityElement.innerText = ` - ${quantity}個`;
        cartItemContainer.appendChild(quantityElement);

        var priceElement = document.createElement("span");
        priceElement.innerText = ` - 價格: $${totalPrice}`;
        cartItemContainer.appendChild(priceElement);

        cartItemsContainer.appendChild(cartItemContainer);
    }
    // 更新購物車彈出視窗內的總金額
    updateTotalPrice();
}

// 更新購物車彈出視窗內的總金額
function updateTotalPrice() {
    var cartItems = JSON.parse(localStorage.getItem("cartItems"));
    var totalPrice = 0;

    // 檢查cartItems是否為空或未定義
    if (!cartItems || cartItems.length === 0) {
        document.getElementById("totalPriceValue").innerText = "0元";
        return;
    }

    // 計算總金額
    for (var i = 0; i < cartItems.length; i++) {
        var cartData = cartItems[i];
        var quantity = cartData.quantity;
        var itemPrice = cartData.productPrice;
        totalPrice += itemPrice * quantity;
    }

    // 更新總金額的span元素
    document.getElementById("totalPriceValue").innerText = totalPrice + "元";
}

							
							// Add close button functionality to hide the shopping cart modal
							function closeCartModal() {
							  document.getElementById("cartModal").style.display = "none";
							}
							
							function goToCheckout() {
							  // TODO: Logic for navigating to the checkout page
							}
							
							// Add a click event listener to the cart button
							document.getElementById("cartButton").addEventListener("click", openCartModal);
							function clearCart() {
                // 清空localStorage中的購物車資料
                localStorage.removeItem("cartItems");

                // 清空購物車內的品項列表
                var cartItemsDiv = document.getElementById("cart-items");
                cartItemsDiv.innerHTML = "";

                // 重設購物車數量並更新畫面
                cartCount = 0;
                document.getElementById('cartCount').innerText = cartCount;

                // 更新購物車彈出視窗內的總金額
                updateTotalPrice();

                // 關閉購物車彈出視窗
                var cartModal = document.getElementById('cartModal');
                var modal = bootstrap.Modal.getInstance(cartModal); // 如果您使用了Bootstrap的Modal，可以透過此方式取得實例
                modal.hide();
            }

						</script>
						<script>
              // 更新購物車資訊
							function updateCartItemHTML(cartData, cartItemId, productPrice) {
							var cartItemContainer = document.createElement("div");
							var productNameElement = document.createElement("span");
							productNameElement.innerText = cartData.productName;
							var quantityElement = document.createElement("span");
							quantityElement.innerText = ` - ${cartData.quantity}個`;
							var totalPrice =  productPrice * cartData.quantity;
							var priceElement = document.createElement("span");
							priceElement.innerText = ` - 價格: $${totalPrice}`;
							
							cartItemContainer.appendChild(productNameElement);
							cartItemContainer.appendChild(quantityElement);
							cartItemContainer.appendChild(priceElement);
							
							document.getElementById("cart-items").appendChild(cartItemContainer);
							}
    
							function handleImageClick(event) {
							event.preventDefault();
							// Logic for handling image click event
							}

							function handleLinkClick(event) {
							event.preventDefault();
							// Logic for handling link click event
							}
              // 重製購買數量為0
							var cartCount = 0;

              // 增加及減少數量
							function increaseQuantity(inputId) {
							var quantityInput = document.getElementById(inputId);
							quantityInput.value = parseInt(quantityInput.value) + 1;
							}

							function decreaseQuantity(inputId) {
							var quantityInput = document.getElementById(inputId);
							var newQuantity = parseInt(quantityInput.value) - 1;
							quantityInput.value = newQuantity < 1 ? 1 : newQuantity;
							}

    function addToCart(productName, inputId, cartIndex) {
    // 使用AJAX向伺服器端API發送請求
    $.ajax({
        type: 'POST',
        url: 'php/shoppage_getproduct.php', // 伺服器端的API URL
        data: { productName: productName },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                var productPrice = response.price;
                var quantityInput = document.getElementById(inputId);
                var quantity = parseInt(quantityInput.value);

                var cartData = {
                    productName: productName,
                    quantity: quantity,
                    productPrice: productPrice, // 直接將商品價格放入購物車資料中
                    totalPrice: productPrice * quantity // 計算並儲存總價格
                };

                // 使用localStorage儲存購物車資料
                var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
                cartItems.push(cartData);
                localStorage.setItem("cartItems", JSON.stringify(cartItems));

                // 更新購物車數量
                cartCount += quantity;
                document.getElementById('cartCount').innerText = cartCount;

                var successModalBody = document.getElementById("successModalBody");
                successModalBody.innerHTML = `已將${productName} ${quantity}個成功加入購物車！`;
                $('#successModal').modal('show');
                setTimeout(function() {
                    $('#successModal').modal('hide');
                    var cartItemId = 'new_cart_item_id';
                    updateCartItemHTML(cartData, cartItemId);
                    quantityInput.value = 1;
                }, 3000); // 3000 milliseconds (3 seconds)                
            } else {
                $('#trouble1Modal').modal('show');
                setTimeout(function() {
                    $('#trouble1Modal').modal('hide');
                }, 3000); // 3000 milliseconds (3 seconds)
            }
        },
        error: function (error) {
            console.error(error);
            $('#trouble2Modal').modal('show');
            setTimeout(function() {
                $('#trouble2Modal').modal('hide');
            }, 3000); // 3000 milliseconds (3 seconds)
        }
    });
}

// 新增function來將購物車內容寫入資料庫
function writeToDatabase() {
    var cartItems = JSON.parse(localStorage.getItem("cartItems"));

    if (!cartItems || cartItems.length === 0) {
      console.log("購物車內沒有商品");
      return;
    }

// 將購物車內的每個商品資料都加入陣列中
for (var i = 0; i < cartItems.length; i++) {
    var productName = cartItems[i].productName;
    var quantity = cartItems[i].quantity;
    var productPrice = cartItems[i].productPrice;
    var totalPrice = cartItems[i].totalPrice;
  
        // 使用AJAX向伺服器端API發送請求
        $.ajax({
      type: 'POST',
      url: 'php/addtocart.php', // 新增的PHP檔案
      data: {
        cartItems: cartItems,
        productName: productName,
        quantity: quantity,
        productPrice: productPrice,
        totalPrice: totalPrice
      },
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          console.log("成功將購物車內容寫入資料庫");
          // 清空localStorage中的購物車資料
          localStorage.removeItem("cartItems");

          // 清空購物車內的品項列表
          var cartItemsDiv = document.getElementById("cart-items");
          cartItemsDiv.innerHTML = "";

          // 重設購物車數量並更新畫面
          cartCount = 0;
          document.getElementById('cartCount').innerText = cartCount;

          // 更新購物車彈出視窗內的總金額
          updateTotalPrice();

          // 關閉購物車彈出視窗
          var cartModal = document.getElementById('cartModal');
          var modal = bootstrap.Modal.getInstance(cartModal);
          modal.hide();
        } else {
          console.log("寫入資料庫時發生錯誤");
        }
      },
      error: function (error) {
        console.error(error);
        console.log("與伺服器通訊時發生錯誤");
      }
    });
    }
  }


							

                            // Add information for each item

						  </script>				  
						
                        <!-- SVG引用 -->
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>

                        <!-- 成功畫面 -->
                        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="alert alert-warning d-flex align-items-center mb-2" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <div>
                                        <p class="mb-0" id="successModalBody"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 問題畫面 -->
                        
                        <div class="modal fade" id="trouble1Modal" tabindex="-1" role="dialog" aria-labelledby="trouble1ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="alert alert-danger d-flex align-items-center mb-2" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        <p class="mb-0">找不到商品價格</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="trouble2Modal" tabindex="-1" role="dialog" aria-labelledby="trouble2ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="alert alert-danger d-flex align-items-center mb-2" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        <p class="mb-0">加入購物車時發生錯誤，請稍後再試。</p>
                                    </div>
                                </div>
                            </div>
                        </div>


<!--登入彈窗區塊，有與JS配合-->
<div id="login-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Close button -->'
            <div class="modal-header">
                <h5 class="modal-title">會員登入</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

    
            <!-- Login form -->
            <form class="form1" action="show_form.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="account">帳號:</label>
                        <input type="text" id="account" name="account" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密碼:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-warning">會員登入</button>
                    <button type="submit" class="btn btn-warning" formaction="member.php">註冊會員</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--側邊攔-->
<div class="sidebar">
    <a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank"><img src="images/facebook.png" style="width: 35px;height:35px;" ></a>
    <a href="https://www.instagram.com/"><img src="images/Instagram.png" style="width: 35px;height:35px;"></a>
    <a href="https://line.me/zh-hant/"><img src="images/line.png" style="width: 35px;height:35px;"></a>
    <a href="#" class="back-to-top"><img src="images/up-arrows.png" style="width: 35px;height:35px;"></a>
</div>

    <!--底部欄 -->
    <footer class="p-4 border-top">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<h3>台南下營 鋐茶鵝</h3>
				</div>
				<div class="col-md-3">
				<h5>關於我們</h5>
					<ul class="list-unstyled">
						<li><a href="about_nologin.html" class="text-decoration">關於鋐茶鵝</a></li>
						<li><a href="index_nologin.html" class="text-decoration">營業資訊</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>購物須知</h5>
					<ul class="list-unstyled">
						<li><a href="common-quest_nologin.html" class="text-decoration">常見問題</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h5>聯絡資訊</h5>
					<ul class="list-unstyled">
						<li><a href="#" class="text-decoration">LINE：官方LINE帳號</a></li>
						<li><a href="https://www.facebook.com/profile.php?id=100091698824828&mibextid=ZbWKwL"target="_blank" class="text-decoration">FACEBOOK：台南下營 鋐茶鵝</a></li>
						<li><a href="mailto:angel19971314@gmail.com" class="text-decoration">E-mail：angel19971314@gmail.com</a></li>
						<li><span style="color:#FEC107">電話：0966218624</span></li>
					</ul>
				</div>
			</div>
		</div>
		</footer>
		<div class="bg-warning text-center">台南下營 鋐茶鵝 © 2023</div>
	

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script>$(".footerpage").load("footer.php");</script>
			
	</body>
</html>