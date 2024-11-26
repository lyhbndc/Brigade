<?php
session_start();
require 'vendor/autoload.php'; // Include Guzzle via Composer

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

// Define PayMongo API Keys
define('PAYMONGO_PUBLIC_KEY', 'pk_test_KdaM7qBivCT1yP1QmVvjTfCB');
define('PAYMONGO_SECRET_KEY', 'sk_test_2s7FBobkTc3Fw2unrueQtiQd');

// Function to create PayMongo Payment Link
function createPaymentLink($amount, $description, $email) {
    $secretKey = PAYMONGO_SECRET_KEY;
    $url = "https://api.paymongo.com/v1/links";

    $data = [
        "data" => [
            "attributes" => [
                "amount" => $amount * 100, // Convert to centavos
                "description" => $description,
                "remarks" => "Brigade Clothing Payment",
                "send_email" => false,
                "currency" => "PHP",
                "metadata" => [
                    "email" => $email,
                ],
            ],
        ],
    ];

    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("$secretKey:"),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['data']['attributes']['checkout_url'];
    } catch (\Exception $e) {
        die('Error creating payment link: ' . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cartData = json_decode($_POST['cartData'], true);

    if (!$cartData) {
        die("Cart data is missing or invalid.");
    }

    $status = "On Process";
    $shippingCost = 100; // Flat-rate shipping cost
    $freeShippingThreshold = 1500; // Free shipping if total is ₱1500 or more

    do {
        $orderID = sprintf('%04d', rand(0, 9999));
        $checkQuery = "SELECT * FROM `order` WHERE OrderID = '$orderID'";
        $checkResult = mysqli_query($conn, $checkQuery);
    } while (mysqli_num_rows($checkResult) > 0);

    $errors = [];
    $sizeColumnMapping = [
        'S' => 'small_stock',
        'M' => 'medium_stock',
        'L' => 'large_stock',
        'XL' => 'xl_stock',
        'XXL' => 'xxl_stock',
    ];

    $totalAmount = 0;

    foreach ($cartData as $item) {
        $product = mysqli_real_escape_string($conn, $item['name']);
        $quantity = (int)$item['quantity'];
        $size = mysqli_real_escape_string($conn, $item['size']);
        $price = floatval(preg_replace('/[^\d.-]/', '', $item['price']));
        $total = $price * $quantity;
        $totalAmount += $total;

        $stockColumn = isset($sizeColumnMapping[$size]) ? $sizeColumnMapping[$size] : null;
        if (!$stockColumn) {
            die("Invalid size selected.");
        }

        $stockCheckQuery = "SELECT $stockColumn FROM products WHERE name = '$product'";
        $stockResult = mysqli_query($conn, $stockCheckQuery);
        $stockRow = mysqli_fetch_assoc($stockResult);

        if ($stockRow) {
            $availableStock = (int)$stockRow[$stockColumn];
            if ($quantity > $availableStock) {
                $errorMessage = "Insufficient stock for $product (Size: $size). Available stock: $availableStock.";
                header("Location: 3shop.php?error=" . urlencode($errorMessage));
                exit();
            } else {
                $newStock = $availableStock - $quantity;
                $updateStockQuery = "UPDATE products SET $stockColumn = $newStock WHERE name = '$product'";
                mysqli_query($conn, $updateStockQuery);
            }
        }

        $query = "INSERT INTO `order` (OrderID, Customer, Product, Quantity, Size, Status, Total, Date, Address)
                  VALUES ('$orderID', '$fullname', '$product', '$quantity', '$size', '$status', '$total', NOW(), '$address')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error inserting into order table: " . mysqli_error($conn));
        }
    }

     // Determine shipping cost
     if ($totalAmount >= $freeShippingThreshold) {
        $shippingCost = 0; 
    }

    $totalAmount += $shippingCost; 



    $paymentLink = createPaymentLink($totalAmount, "Brigade Clothing Order Checkout", $email);

    if ($paymentLink) {
        echo "<script>
            localStorage.removeItem('cartItems_{$user}');
            window.location.href = '$paymentLink';
        </script>";
        exit();
    } else {
        echo "<script>alert('Failed to create payment link. Please try again.');</script>";
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
		<div class="top_nav">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
					<div class="top_nav_left">
        </div>
					
					</div>
				</div>
			</div>
		</div>

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
</body>
</html>
