<?php
session_start();
$user = $_SESSION['user'];
$conn = mysqli_connect("localhost", "root", "", "brigade");

if (!$user) {
    // Redirect to login page if the user is not logged in
    header("Location: 4login.php");
    exit();
}

// Fetch user details
$query = "SELECT * FROM user WHERE Username = '$user'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fullname = $row["FirstName"] . ' ' . $row["LastName"];
        $email = $row["Email"];
        $address = $row["Address"];
        $contact = $row["Contact"];
        $city = $row["City"];
        $state = $row["State"];
        $zip = $row["Zip"];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartData = json_decode($_POST['cartData'], true); // Decode JSON to an array
    $status = "On Process"; // Set the initial status

    // Generate a unique Order ID (4 digits)
    do {
        $orderID = sprintf('%04d', rand(0, 9999)); // Random number between 0000 to 9999
        $checkQuery = "SELECT * FROM `order` WHERE OrderID = '$orderID'";
        $checkResult = mysqli_query($conn, $checkQuery);
    } while (mysqli_num_rows($checkResult) > 0); // Ensure uniqueness

    if (is_array($cartData)) {
        foreach ($cartData as $item) {
            $product = mysqli_real_escape_string($conn, $item['name']);
            $quantity = (int)$item['quantity'];
            $price = floatval(preg_replace('/[^\d.-]/', '', $item['price'])); // Clean price and ensure it's a float
            $total = $price * $quantity; // Calculate total based on price and quantity

            // Insert order details into the database
            $query = "INSERT INTO `order` (OrderID, Customer, Product, Quantity, Status, Total, Date) VALUES ('$orderID', '$fullname', '$product', '$quantity', '$status', '$total', NOW())";
            $result = mysqli_query($conn, $query);
        }
        // Clear cart items from local storage after successful order
        echo "<script>
                alert('Order placed successfully!'); 
                localStorage.removeItem('cartItems_" . addslashes($user) . "'); // Clear items from local storage
                window.location.href='1homepage.php'; 
              </script>";
        exit();
    }
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
        .checkout-container {
            max-width: 600px;
            margin: 200px auto;
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
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
}

.checkout-button:hover {
    background-color: #555; /* Change background color on hover */
    transform: scale(1.0); /* Slightly increase size when hovered */
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

                <form method="POST" action="">
                    <!-- Add hidden input to pass cart data -->
                    <input type="hidden" id="cartData" name="cartData">

                    <!-- Personal Information -->
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($fullname); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <!-- Shipping Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" value="<?php echo htmlspecialchars($address); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" placeholder="Enter your contact number" value="<?php echo htmlspecialchars($contact); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" value="<?php echo htmlspecialchars($city); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" value="<?php echo htmlspecialchars($state); ?>" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" id="zip" value="<?php echo htmlspecialchars($zip); ?>" required>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="form-group">
                        <label for="paymentMethod">Select Payment Method</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod" required onchange="togglePaymentDetails()">
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="paypal">PayPal</option>
                            <option value="card">Credit Card</option>
                            <option value="gcash">GCash</option>
                        </select>
                    </div>

                    <!-- Payment Details - Hidden by default, shown based on selected method -->
                    <div id="paypalDetails" class="payment-details" style="display:none;">
                        <div class="form-group">
                            <label for="paypalEmail">PayPal Email</label>
                            <input type="email" class="form-control" id="paypalEmail" placeholder="Enter your PayPal email">
                        </div>
                    </div>

                    <div id="cardDetails" class="payment-details" style="display:none;">
                        <div class="form-group">
                            <label for="cardName">Name on Card</label>
                            <input type="text" class="form-control" id="cardName" placeholder="Name as it appears on card" required>
                        </div>

                        <div class="form-group">
                            <label for="cardNumber">Credit Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="XXXX-XXXX-XXXX-XXXX" required pattern="\d{4}(-)?\d{4}(-)?\d{4}(-)?\d{4}" title="Card number must be in XXXX-XXXX-XXXX-XXXX format">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="expiry">Expiration Date</label>
                                <input type="text" class="form-control" id="expiry" placeholder="MM/YY" required pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Expiration date must be in MM/YY format">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" id="cvv" placeholder="XXX" required pattern="\d{3}" title="CVV must be 3 digits">
                            </div>
                        </div>
                    </div>

                    <div id="gcashDetails" class="payment-details" style="display:none;">
                        <div class="form-group">
                            <label for="gcashNumber">GCash Number</label>
                            <input type="text" class="form-control" id="gcashNumber" placeholder="Enter your GCash number">
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Define the cart key based on the user session
    const cartKey = `cartItems_${<?php echo json_encode($user); ?>}`;
    let cartItems = JSON.parse(localStorage.getItem(cartKey)) || [];

	function updateCart() {
    // Select the cart count element
    const cartCountElement = document.getElementById('checkout_items');
    
    // Display the count of unique items in the cart
    cartCountElement.textContent = cartItems.length;
}


    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const productItem = button.closest('.product-item');
            const productId = productItem.getAttribute('data-id');
            const productName = productItem.querySelector('.product_name a').textContent;
            const productImage = productItem.querySelector('.product_image img').src;
            const productPrice = productItem.querySelector('.product_price').textContent;

            // Check if the item is already in the cart
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex > -1) {
                // Increase quantity if item already exists
                cartItems[existingItemIndex].quantity += 1;
            } else {
                // Add new item with default quantity of 1
                cartItems.push({ id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 });
            }

            // Save updated cart to localStorage and update the cart display
            localStorage.setItem(cartKey, JSON.stringify(cartItems));
            updateCart();
            alert(`${productName} has been added to your cart!`);
        });
    });

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', updateCart);
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
   <script>
    function togglePaymentDetails() {
        const paymentMethod = document.getElementById('paymentMethod').value;
        const paypalDetails = document.getElementById('paypalDetails');
        const cardDetails = document.getElementById('cardDetails');
        const gcashDetails = document.getElementById('gcashDetails');

        // Hide all payment details first
        paypalDetails.style.display = 'none';
        cardDetails.style.display = 'none';
        gcashDetails.style.display = 'none';

        // Show the relevant payment details based on the selected method
        if (paymentMethod === 'paypal') {
            paypalDetails.style.display = 'block';
        } else if (paymentMethod === 'card') {
            cardDetails.style.display = 'block';
        } else if (paymentMethod === 'gcash') {
            gcashDetails.style.display = 'block';
        }
    }

    // Function to display the confirmation message after successful form submission
    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from actually submitting

        // Show confirmation message
        document.getElementById('confirmationMessage').style.display = 'block';

        // Optionally, hide the checkout form after successful submission
        document.getElementById('checkoutForm').style.display = 'none';
    });
</script>
</body>
</html>
