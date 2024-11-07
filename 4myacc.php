<?php
session_start();

    $user = $_SESSION['user'];
    $conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user'])) {
    // Redirect to login page if the user is not logged in
    header("Location: 4login.php");
    exit();
}

$fullname = ""; // Initialize $fullname variable

$query = "SELECT * FROM user WHERE Username = '$user'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $city = $row["City"];
        $email = $row["Email"];
        $address = $row["Address"];
        $fullname = $row["FirstName"] . ' ' . $row["LastName"];
    }
} 
$orderQuery = "SELECT * FROM `order` WHERE Customer = '$fullname' ORDER BY Date DESC";
$orderResult = mysqli_query($conn, $orderQuery);

mysqli_close($conn);
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
    <link rel="stylesheet" type="text/css" href="styles/single_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
    <style>
        body {
            background-color: white;
            color: black;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: black;
            font-weight: bold;
        }
        .footer-logo{
           cursor: default; 
        }
        .account-container {
        width: 80%;
        max-width: 900px;
        margin: 0 auto;
        font-family: Arial, sans-serif;
        color: #333;
    }
    .logout {
        color: #333;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
    }

    .account-content {
        display: flex;
        justify-content: space-between;
        padding: 20px 0;
    }

    .order-history, .account-details {
        width: 48%;
    }

    .order-history h2, .account-details h2 {
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
        color: #333;
    }

    .order-history p, .account-details p {
        font-size: 14px;
        margin: 10px 0;
        color: #666;
    }

    .view-addresses {
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }
    .title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #ddd;
    }

    .title h1 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }
    </style>
</head>

<body>

    <div class="super_container">
        <header class="header trans_300">
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
                                <a href="#"><img src="assets/1.png"></a>
                            </div>
                            <nav class="navbar">
                                <ul class="navbar_menu">
                                    <li><a href="1homepage.php">home</a></li>
                                    <li><a href="3shop.php">shop</a></li>
                                    <li><a href="#">new</a></li>
                                    <li><a href="#">on sale</a></li>
                                </ul>
                                <ul class="navbar_user">
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                                    <li class="checkout">
                                        <a href="3cart.php">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span id="checkout_items" class="checkout_items">0</span>
                                        </a>
                                    </li>
                                    <li>
        <a href="logout.php" class="logout">Logout</a> <!-- Added Logout Button beside the cart icon -->
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
        <br><br><br><br><br><br><br>
                    <div class="title">
                    <div class="account-container">
                        <h1>My Account</h1>
                        <div class="account-content">
                            <div class="order-history">
                                <h2>Order History</h2>
                               <!-- Recent Orders Table -->
<table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($orderResult && mysqli_num_rows($orderResult) > 0): ?>
                                <?php while ($orderRow = mysqli_fetch_assoc($orderResult)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($orderRow['OrderID']); ?></td>
                                        <td><?php echo htmlspecialchars($orderRow['Product']); ?></td>
                                        <td><?php echo htmlspecialchars($orderRow['Quantity']); ?></td>
                                        <td>
                                            <?php if ($orderRow['Status'] == "Shipped"): ?>
                                                <span class="badge badge-success"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-warning"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($orderRow['Total']); ?></td>
                                        <td><?php echo htmlspecialchars($orderRow['Date']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No orders found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                    <div class="account-details">
    <h2>Account Details</h2>
    <p><strong>Name:</strong> <span><?php echo $fullname; ?></span></p>
    <p><strong>Email:</strong> <span><?php echo $email; ?></span></p>
    <p><strong>Address:</strong> <span><?php echo $address; ?></span></p>
    <p><strong>City:</strong> <span><?php echo $city; ?></span></p>
        <p><strong>Country:</strong> <span>Philippines</span></p>
    </div>
</div>
                    </div>
                    <br><br><br><br><br><br><br>
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
                            <img src="assets/Untitled design.png" class="footer-logo">
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
                    <h6> ${item.name}</h6>
                    <p>₱ ${item.price}</p>
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
        const subtotal = cartItems.reduce((total, item) => total + parseInt(item.price.replace(/[^\d.-]/g, '')) * item.quantity, 0);
        const shipping = subtotal >= freeShippingThreshold ? 0 : shippingCost;
        const total = subtotal + shipping;

        // Display the summary
        document.getElementById('order-subtotal').textContent = `Subtotal: ₱ ${subtotal.toFixed(2)}`;
        document.getElementById('order-shipping').textContent = `Shipping: ₱ ${shipping.toFixed(2)}`;
        document.getElementById('order-total').textContent = `Total    ₱ ${total.toFixed(2)}`;
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
        cartCountElement.textContent = cartItems.reduce((total, item) => total + (item.quantity || 1), 0);
    }

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
