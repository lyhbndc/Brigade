<!DOCTYPE html>
<html lang="en">
<head>
    <title>Brigade Clothing</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles/single_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
    <style>
        .checkout-container {
            max-width: 600px;
            margin: 5px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .checkout-header {
            font-weight: bold;
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 20px;
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
        .order-summary {
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
}

.order-summary h4 {
    font-size: 1.25em;
    font-weight: bold;
    margin-bottom: 15px;
}

.summary-line-item, .summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px 0;
    font-size: 1em;
}

.summary-total {
    font-weight: bold;
    font-size: 1.1em;
}

.summary-divider {
    border: none;
    border-top: 1px solid #ddd;
    margin: 15px 0;
}

    </style>
</head>

<body>

    <div class="super_container">
        <header class="header trans_300">
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
                                    <li><a href="index.html">home</a></li>
                                    <li><a href="#">shop</a></li>
                                    <li><a href="#">new</a></li>
                                    <li><a href="#">on sale</a></li>
                                </ul>
                                <ul class="navbar_user">
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                                    <li class="checkout">
                                        <a href="3cart.php">
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
                    <li class="menu_item"><a href="#">home</a></li>
                    <li class="menu_item"><a href="#">shop</a></li>
                    <li class="menu_item"><a href="#">new</a></li>
                    <li class="menu_item"><a href="#">on sale</a></li>
                </ul>
            </div>
        </div>

        <div class="container single_product_container">
            <div class="row">
                <div class="col">
                    <div class="checkout-container">
                        <div class="checkout-header">Checkout</div>
                        <div class="order-summary">
    <h4>Order Summary</h4>
    <div class="summary-line-item">
        <span>Subtotal</span>
        <span id="order-subtotal">₱0.00</span>
    </div>
    <div class="summary-line-item">
        <span>Estimated Delivery & Handling</span>
        <span id="order-shipping">₱0.00</span>
    </div>
    <hr class="summary-divider">
    <div class="summary-total">
        <span>Total</span>
        <span id="order-total"><strong>₱0.00</strong></span>
    </div>
</div>

                        <form>
                            <!-- Personal Information -->
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                    
                            <!-- Shipping Address -->
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="zip">Zip</label>
                                    <input type="text" class="form-control" id="zip" required>
                                </div>
                            </div>
                    
                            <!-- Payment Information -->
                            <div class="form-group">
                                <label for="cardName">Name on Card</label>
                                <input type="text" class="form-control" id="cardName" placeholder="Name as it appears on card" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="cardNumber">Credit Card Number</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                            </div>
                    
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="expiry">Expiration Date</label>
                                    <input type="text" class="form-control" id="expiry" placeholder="MM/YY" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="XXX" required>
                                </div>
                            </div>
                    
                            <button type="submit" class="checkout-button">Place Order</button>
                        </form>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    function updateCart() {
        const cartCountElement = document.getElementById('checkout_items');
        cartCountElement.textContent = cartItems.reduce((total, item) => total + (item.quantity || 1), 0);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default anchor click behavior
            const productItem = button.closest('.product-item');
            const productId = productItem.getAttribute('data-id');
            const productName = productItem.querySelector('.product_name a').textContent;
            const productImage = productItem.querySelector('.product_image img').src;
            const productPrice = productItem.querySelector('.product_price').textContent;

            // Check if item already exists in the cart
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex > -1) {
                // Increase quantity if it already exists
                cartItems[existingItemIndex].quantity += 1;
            } else {
                // Add new item to cart with a default quantity of 1
                cartItems.push({ id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 });
            }

            updateCart(); // Update the cart display
            alert(`${productName} has been added to your cart!`);
        });
    });
    function calculateOrderSummary() {
    const shippingCost = 250; // Flat-rate shipping cost
    const freeShippingThreshold = 1500; // Free shipping for orders above this threshold

    // Calculate subtotal
    const subtotal = cartItems.reduce((total, item) => total + parseFloat(item.price.replace(/[^\d.-]/g, '')) * item.quantity, 0);

    // Determine shipping cost based on subtotal
    const shipping = subtotal >= freeShippingThreshold ? 0 : shippingCost;

    // Calculate total
    const total = subtotal + shipping;

    // Display the calculated amounts in the summary section
    document.getElementById('order-subtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('order-shipping').textContent = `₱${shipping.toFixed(2)}`;
    document.getElementById('order-total').textContent = `₱${total.toFixed(2)}`;
}

// Call calculateOrderSummary to display the order summary when the page loads
document.addEventListener('DOMContentLoaded', calculateOrderSummary);


    // Update cart count on page load
    updateCart();
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
