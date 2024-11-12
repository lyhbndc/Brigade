<?php
session_start();
$user = $_SESSION['user'] ?? null; // Handle cases where user might not be set

if (!$user) {
    // Redirect to login page if the user is not logged in
    header("Location: 4login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Brigade Clothing</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
    <style>
        .cart-page-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    max-width: 800px;
    margin: 120px auto;
}

.cart-container {
    flex-grow: 1; /* Allows the cart items container to take remaining space */
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.summary-container {
    width: 300px; /* Fixed width for the summary container */
    height: 320px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

        .cart-header, .summary-header {
            font-weight: bold;
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            border-radius: 4px;
        }
        .cart-item-info {
            flex-grow: 1;
            margin-left: 15px;
        }
        .cart-item-info h6 {
            margin: 0;
            font-size: 1em;
            font-weight: bold;
        }
        .cart-item-info p {
            margin: 5px 0;
            font-size: 0.9em;
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
        }
        .cart-item-quantity input {
            width: 40px;
            text-align: center;
            margin: 0 5px;
        }
        .checkout-button {
            width: 100%;
            padding: 12px;
            background-color: #333;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
        }
        .checkout-button:hover {
            background-color: #555; 
            cursor: pointer;
        }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        .summary-total {
    font-weight: bold;
    font-size: 1.1em;
}

    </style>
</head>

<body>

    <div class="super_container">
            <!-- Top Navigation -->
            <div class="top_nav">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="top_nav_left">
                                <div class="marquee">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="top_nav_right">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Navigation -->
            <div class="main_nav_container">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <div class="logo_container">
                                <a href="1index.php"><img src="assets/1.png"></a>
                            </div>
                            <nav class="navbar">
                                <ul class="navbar_menu">
                                    <li><a href="1homepage.php">home</a></li>
                                    <li><a href="3shop.php">shop</a></li>
                                    <li><a href="3new.php">new</a></li>
                                    <li><a href="3onsale.php">on sale</a></li>
                                </ul>
                                <ul class="navbar_user">
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                                    <li class="checkout">
                                        <a href="#">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span id="checkout_items" class="checkout_items">2</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="hamburger_container">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
    
        </header>
    
        <div class="fs_menu_overlay"></div>
    
        <!-- Hamburger Menu -->
        <div class="hamburger_menu">
            <div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
            <div class="hamburger_menu_content text-right">
                <ul class="menu_top_nav">
                    <li class="menu_item has-children">
                        <a href="#">
                            My Account
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="menu_selection">
                            <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
                            <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li>
                        </ul>
                    </li>
                    <li class="menu_item"><a href="1homepage.php">home</a></li>
                    <li class="menu_item"><a href="3shop.php">shop</a></li>
                    <li class="menu_item"><a href="3new.php">new</a></li>
                    <li class="menu_item"><a href="3onsale.php">on sale</a></li>
                </ul>
            </div>
        </div>
        
        <div class="container single_product_container">
            <div class="row">
                <div class="col">
                <div class="container cart-page-container">
            <!-- Cart Items Container -->
            <div class="cart-container">
                <div class="cart-header">Cart</div>
                <div id="cart-items-container"></div>
            </div>

                        <!-- Order Summary -->
                        <div class="summary-container">
                <div class="summary-header">Order Summary</div>
                <p id="order-subtotal">Subtotal: ₱0.00</p>
                <p id="order-shipping">Estimated Delivery & Handling: ₱0.00</p>
                <hr class="summary-divider">
    <div class="summary-total">
        <span id="order-total"><strong>₱0.00</strong></span>
        <hr class="summary-divider">
                <div class="cart-footer">
                    <a href="3checkout.php"><button class="checkout-button">CHECK OUT</button></a>
                </div>
            </div>
        </div>
        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>


<!-- Footer -->
<br><br><br><br>
<footer style="background-color: black; color: white;" class="bg3 p-t-75 p-b-32">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h4 class="stext-301 cl0 p-b-30">
					<a href="#"><img src="assets/Untitled design.png" class="footer-logo"></a>
				</h4>
				<p class="stext-107 cl7 size-201">
					Any questions? Let us know in store at Brigade Clothing, Brgy. Sta Ana, Taytay, Rizal.
				</p>
			</div>
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Company</h7>
	
				<ul>
					<li class="p-b-10"><a href="5about.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">About Brigade</a></li>
					<li class="p-b-10"><a href="5features.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Features</a></li>
				</ul>
			</div>
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Main Menu</h7>
				<ul>
					<li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Home</a></li>
					<li class="p-b-10"><a href="3shop.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shop</a></li>
					<li class="p-b-10"><a href="3new.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">New</a></li>
					<li class="p-b-10"><a href="3onsale.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">On Sale</a></li>
				</ul>
			</div>
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Socials</h7>
				<ul>
					<li class="p-b-10"><a href="https://shopee.ph/brigadeclothing?originalCategoryId=11044828#product_list" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shopee</a></li>
					<li class="p-b-10"><a href="https://www.lazada.com.ph/shop/brigade-clothing?path=index.htm&lang=en&pageTypeId=1" class="stext-107 cl7 footer-link hov-cl1 trans-04">Lazada</a></li>
					<li class="p-b-10">
						<a href="https://www.facebook.com/BrigadeWorld"><i class="fa fa-facebook footer-icon" aria-hidden="true"></i></a>
						<a href="https://www.instagram.com/brigadeclothing_official/"><i class="fa fa-instagram footer-icon" aria-hidden="true"></i></a>
					</li>
				</ul>
			</div>
		</div>
		<br><br><br>
		<div class="footer-bottom text-center">
			<p>© 2024 Brigade Clothing. All rights reserved.</p>
		</div>
	</div>
	<br><br>
</footer>
</div>
<!-- Other HTML content -->

<!-- Add this before the closing body tag -->
<script>
        const user = <?php echo json_encode($user); ?>; // Get the current user from PHP
        const cartKey = `cartItems_${user}`; // Unique key for this user's cart items
        let cartItems = JSON.parse(localStorage.getItem(cartKey)) || []; // Fetch items

        const cartItemsContainer = document.getElementById('cart-items-container');
        const shippingCost = 100;
        const freeShippingThreshold = 1500;

        function renderCartItems() {
            cartItemsContainer.innerHTML = ''; // Clear the container
            if (cartItems.length === 0) {
                cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
                updateCartCount();
                calculateSummary();
                return;
            }

            cartItems.forEach((item, index) => {
                const cartItemDiv = document.createElement('div');
                cartItemDiv.className = 'cart-item';
                cartItemDiv.innerHTML = `
                    <img src="${item.image}" alt="Product Image">
                    <div class="cart-item-info">
                        <h6> ${item.name}</h6>
                        <p> ${item.price}</p>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(${index}, -1)">-</button>
                        <input type="number" value="${item.quantity || 1}" min="1" max="5" id="quantity-${index}">
                        <button class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(${index}, 1)">+</button>
                    </div>
                    <button class="btn btn-link text-danger" onclick="removeItem(${index})"><i class="fa fa-trash"></i></button>
                `;
                cartItemsContainer.appendChild(cartItemDiv);
            });

            updateCartCount();
            calculateSummary();
        }

        function calculateSummary() {
            const subtotal = cartItems.reduce((total, item) => total + parseInt(item.price.replace(/[^\d.-]/g, '')) * item.quantity, 0);
            const shipping = subtotal >= freeShippingThreshold ? 0 : shippingCost;
            const total = subtotal + shipping;

            document.getElementById('order-subtotal').textContent = `Subtotal: ₱${subtotal.toFixed(2)}`;
            document.getElementById('order-shipping').textContent = `Shipping: ₱${shipping.toFixed(2)}`;
            document.getElementById('order-total').textContent = `Total: ₱${total.toFixed(2)}`;
        }

        function changeQuantity(index, delta) {
            const quantityInput = document.getElementById(`quantity-${index}`);
            let quantity = parseInt(quantityInput.value) + delta;
            quantity = Math.max(1, Math.min(5, quantity)); // Clamp quantity between 1 and 5
            quantityInput.value = quantity;

            cartItems[index].quantity = quantity; // Update quantity in cart array
            localStorage.setItem(cartKey, JSON.stringify(cartItems)); // Update local storage
            renderCartItems(); // Re-render items and summary
        }

        function removeItem(index) {
            cartItems.splice(index, 1); // Remove item
            localStorage.setItem(cartKey, JSON.stringify(cartItems)); // Update storage
            renderCartItems(); // Re-render items and summary
        }
        

        function updateCartCount() {
    const cartCountElement = document.getElementById('checkout_items');
    cartCountElement.textContent = cartItems.length; // Display the count of unique items
}

        // Initial render
        renderCartItems();
    </script>

<script>
    // JavaScript to make the navbar opaque when scrolling
    window.addEventListener('scroll', function() {
        const mainNav = document.querySelector('.main_nav_container');
        
        if (window.scrollY > 50) { // Adjust the scroll threshold as needed
            mainNav.classList.add('opaque');
        } else {
            mainNav.classList.remove('opaque');
        }
    });
</script>
</body>

</html>

