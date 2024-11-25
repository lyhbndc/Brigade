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
    <link rel="stylesheet" type="text/css" href="styles/cart.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
</head>
<body>

    <div class="super_container">
        <header class="header trans_300">
            <!-- Top Navigation -->
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

            <!-- Main Navigation -->
            <div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="#"><img src="assets/1.png"></a>
						</div>
						<nav class="navbar">
                    <ul class="navbar_menu">
                        <li><a href="#">home</a></li>
                        <li><a href="3shop.php">shop</a></li>
                        <li><a href="3new.php">new</a></li>
                        
                    </ul>
                    <ul class="navbar_user">
					<li class="dropdown">
        <a href="#" id="searchDropdown" role="button" onclick="toggleDropdown(event)" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-search" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu search-dropdown" id="searchDropdownMenu">
            <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="filterNames()">
			<ul id="nameList" class="name-list">
                <li class="name-item">
                    <img src="assets/359801864_251602164294072_4089427261190148458_n.jpg" alt="1" class="name-item-img">
                    LETS GET HIGH
                </li>
                <li class="name-item">
                    <img src="assets/359801864_251602164294072_4089427261190148458_n.jpg" alt="2" class="name-item-img">
                    LUCKY BLACK
                </li>
                <li class="name-item">
                    <img src="assets/359801864_251602164294072_4089427261190148458_n.jpg" alt="3" class="name-item-img">
                    CHASE DREAM BLUE
                </li>
                <li class="name-item">
                    <img src="assets/359801864_251602164294072_4089427261190148458_n.jpg" alt="4" class="name-item-img">
                    COLDEST BLUE
                </li>
            </ul>
        </div>
    </li>
                        
                        <!-- User Dropdown -->
                        <li class="dropdown">
                            <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="4login.php">Sign In</a>
								<a class="dropdown-item" href="4myacc.php">Account</a>
								<a class="dropdown-item" href="4recentorders.php">Recent Orders</a>
								<a class="dropdown-item" href="7adminlogin.php">Admin</a>
								<a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                        
                        <li class="checkout">
                            <a href="3cart.php">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="checkout_items" class="checkout_items">0</span>
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
        <form action="3checkout.php" method="POST">
    <input type="hidden" id="cartDataField" name="cartData">
    <button type="submit" class="checkout-button">Checkout</button>
</form>
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
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">About Brigade</a></li>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Features</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-b-50">
                        <br>
                        <h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Main Menu</h7>
                        <ul>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Home</a></li>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shop</a></li>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">New</a></li>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">On Sale</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-b-50">
                        <br>
                        <h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Socials</h7>
                        <ul>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shopee</a></li>
                            <li class="p-b-10"><a href="#" class="stext-107 cl7 footer-link hov-cl1 trans-04">Lazada</a></li>
                            <li class="p-b-10">
                                <a href="#"><i class="fa fa-facebook footer-icon" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram footer-icon" aria-hidden="true"></i></a>
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
    // Initialize cart with a user-specific key
    const user = <?php echo json_encode($user); ?>; // Get the current user from PHP
    const cartKey = `cartItems_${user}`; // Create a unique key for this user's cart items
    const cartItems = JSON.parse(localStorage.getItem(cartKey)) || []; // Fetch items from user-specific key

    const cartItemsContainer = document.getElementById('cart-items-container');
    const shippingCost = 100; // Flat-rate shipping cost
    const freeShippingThreshold = 1500; // Threshold for free shipping

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
                <h6>${item.name}</h6>
                <p>Size: ${item.size}</p>
                <p>${item.price}</p>
            </div>
            <div class="cart-item-quantity">
                <button class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(${index}, -1)">-</button>
                <input type="number" value="${item.quantity || 1}" min="1" id="quantity-${index}">
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
        const subtotal = cartItems.reduce((total, item) => total + parseFloat(item.price.replace(/[^\d.-]/g, '')) * item.quantity, 0);
        const shipping = subtotal >= freeShippingThreshold ? 0 : shippingCost;
        const total = subtotal + shipping;

        // Display the summary
        document.getElementById('order-subtotal').textContent = `Subtotal: ₱${subtotal.toFixed(2)}`;
        document.getElementById('order-shipping').textContent = `Shipping: ₱${shipping.toFixed(2)}`;
        document.getElementById('order-total').textContent = `Total    ₱${total.toFixed(2)}`;
    }

    function changeQuantity(index, delta) {
        const quantityInput = document.getElementById(`quantity-${index}`);
        let quantity = parseInt(quantityInput.value) + delta;
        if (quantity < 1) {
            quantity = 1; // Minimum quantity is 1
        }
        quantityInput.value = quantity;

        // Update the item in the cartItems array
        cartItems[index].quantity = quantity;
        // Update user-specific local storage
        localStorage.setItem(cartKey, JSON.stringify(cartItems));
        updateCartCount(); // Update the cart count in the header
        calculateSummary();
    }

    function removeItem(index) {
        // Remove the item from the cart items array
        cartItems.splice(index, 1);
        // Update user-specific local storage
        localStorage.setItem(cartKey, JSON.stringify(cartItems));
        // Re-render the cart items
        renderCartItems();
        updateCartCount();
    }

    function updateCartCount() {
    const cartCountElement = document.getElementById('checkout_items');
    cartCountElement.textContent = cartItems.length; // Display unique item count
}

    document.querySelector('.checkout-button').addEventListener('click', function() {
    const cartDataField = document.getElementById('cartDataField');
    cartDataField.value = JSON.stringify(cartItems); // Set the cart items in JSON format
});

    // Call the function to render cart items
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

