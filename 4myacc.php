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
    while ($row = mysqli_fetch_assoc($result)) {
        $city = $row["City"];
        $email = $row["Email"];
        $address = $row["Address"];
        $fullname = $row["FirstName"] . ' ' . $row["LastName"];
    }
}

$orderQuery = "SELECT * FROM `order` WHERE Customer = '$fullname' ORDER BY Date DESC";
$orderResult = mysqli_query($conn, $orderQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $product = mysqli_real_escape_string($conn, $_POST['product']); // Get product from POST data
    $action = mysqli_real_escape_string($conn, $_POST['action']);

    // Determine the new status based on the action
    $newStatus = '';
    switch ($action) {
        case 'Received':
            $newStatus = 'Order Completed';
            break;
        case 'Refund':
            $newStatus = 'Refunded';
            break;
        case 'Cancel':
            $newStatus = 'Cancelled';
            break;
        default:
            echo 'Invalid action';
            exit();
    }

    // Update the order status in the database using both OrderID and Product
    $query = "UPDATE `order` SET Status = '$newStatus' WHERE OrderID = '$orderId' AND Product = '$product'";
    if (mysqli_query($conn, $query)) {
        echo "Order status updated to '$newStatus'";
    } else {
        echo "Error updating order: " . mysqli_error($conn);
    }

    // Additional actions based on the type of request
    if ($action === 'Cancel') {
        // Fetch the order details before inserting into the `cancel_order` table
        $fetchOrderQuery = "SELECT * FROM `order` WHERE OrderID = '$orderId' AND Product = '$product'";
        $fetchOrderResult = mysqli_query($conn, $fetchOrderQuery);

        if ($fetchOrderResult && mysqli_num_rows($fetchOrderResult) > 0) {
            $orderDetails = mysqli_fetch_assoc($fetchOrderResult);
            $quantity = mysqli_real_escape_string($conn, $orderDetails['Quantity']);
            $total = mysqli_real_escape_string($conn, $orderDetails['Total']);
            $date = mysqli_real_escape_string($conn, $orderDetails['Date']);

            // Insert canceled order into the `cancel_order` table
            $insertQuery = "
                INSERT INTO `cancel_order` (OrderID, Customer, Product, Quantity, Status, Total, Date)
                VALUES ('$orderId', '$fullname', '$product', '$quantity', 'Order Cancelled', '$total', '$date')
            ";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Order successfully inserted into `cancel_order`.";
            } else {
                echo "Error inserting order into `cancel_order`: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Order not found.";
        }
    }

    if ($action === 'Received') {
        // Fetch the order details before inserting into the `complete_order` table
        $fetchOrderQuery = "SELECT * FROM `order` WHERE OrderID = '$orderId' AND Product = '$product'";
        $fetchOrderResult = mysqli_query($conn, $fetchOrderQuery);

        if ($fetchOrderResult && mysqli_num_rows($fetchOrderResult) > 0) {
            $orderDetails = mysqli_fetch_assoc($fetchOrderResult);
            $quantity = mysqli_real_escape_string($conn, $orderDetails['Quantity']);
            $total = mysqli_real_escape_string($conn, $orderDetails['Total']);
            $date = mysqli_real_escape_string($conn, $orderDetails['Date']);

            // Insert completed order into the `complete_order` table
            $insertQuery = "
                INSERT INTO `complete_order` (OrderID, Customer, Product, Quantity, Status, Total, Date)
                VALUES ('$orderId', '$fullname', '$product', '$quantity', 'Order Completed', '$total', '$date')
            ";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Order successfully inserted into `complete_order`.";
            } else {
                echo "Error inserting order into `complete_order`: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Order not found.";
        }
    }

    if ($action === 'Refund') {
        // Fetch the order details before inserting into the `refund_order` table
        $fetchOrderQuery = "SELECT * FROM `order` WHERE OrderID = '$orderId' AND Product = '$product'";
        $fetchOrderResult = mysqli_query($conn, $fetchOrderQuery);

        if ($fetchOrderResult && mysqli_num_rows($fetchOrderResult) > 0) {
            $orderDetails = mysqli_fetch_assoc($fetchOrderResult);
            $quantity = mysqli_real_escape_string($conn, $orderDetails['Quantity']);
            $total = mysqli_real_escape_string($conn, $orderDetails['Total']);
            $date = mysqli_real_escape_string($conn, $orderDetails['Date']);

            // Insert refunded order into the `refund_order` table
            $insertQuery = "
                INSERT INTO `refund_order` (OrderID, Customer, Product, Quantity, Status, Total, Date)
                VALUES ('$orderId', '$fullname', '$product', '$quantity', 'Order Refunded', '$total', '$date')
            ";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Order successfully inserted into `refund_order`.";
            } else {
                echo "Error inserting order into `refund_order`: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Order not found.";
        }
    }
}

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

.table {
    width: 100%;
    border-collapse: collapse; /* Ensures borders are collapsed together */
    margin: 20px 0;
    font-family: 'Arial', sans-serif;
    background-color: #fff; /* White background */
}

.thead-dark {
    background-color: #343a40; /* Dark background for header */
    color: white; /* White text color */
}

.table th {
    padding: 12px 15px;
    font-size: 16px;
    text-align: left;
}


.table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    font-size: 14px;
    color: #333;
}


.table tr:nth-child(even) {
    background-color: #f9f9f9; /* Light grey for even rows */
}


.table tr:hover {
    background-color: #f1f1f1; /* Slightly darker grey on hover */
}


.table th, .table td {
    border: 1px solid #ddd;
}


.button-container {
    display: flex;
    gap: 10px;
}


.btn {
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}


.btn-success {
    background-color: #28a745;
    color: white;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}


.btn-warning {
    background-color: #ffc107;
    color: black;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}


.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}


.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.badge {
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 3px;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: black;
}
.butn {
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    width: 120px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Primary Button (for Edit Account) */
.btn-primary {
    background-color: black;
    color: white;
}

.btn-primary:hover {
    background-color: gray;
    transform: scale(1.05);
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
                                    <li><a href="4recentorders.php">Recent Orders</a></li>
                                    <li> <a href="logout.php" class="logout">Logout</a><li>
                                
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
        <br><br><br><br><br><br><br>
                    <div class="title">
                    <div class="account-container">
                        <h1>My Account</h1>
</div>
</table>

    <div class="account-details">
    <h2>Account Details</h2>
    <p><strong>Name:</strong> <span><?php echo $fullname; ?></span></p>
    <p><strong>Email:</strong> <span><?php echo $email; ?></span></p>
    <p><strong>Address:</strong> <span><?php echo $address; ?></span></p>
    <p><strong>City:</strong> <span><?php echo $city; ?></span></p>
    <p><strong>Country:</strong> <span>Philippines</span></p>
    </div>
    <a href="4logout.php"><button class="butn btn-primary">Logout</button></a>
</div>
                    </div>
                    <br><br><br><br>
                </div>   
                </div>   
                    
    </div>
    </div>    </div>    </div> 
            
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
document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');
        const product = this.getAttribute('data-product'); // New line
        const action = this.getAttribute('data-action');
        
        if (confirm(`Are you sure you want to ${action} this order?`)) {
            const buttonsInRow = this.parentNode.querySelectorAll('.action-button');
            buttonsInRow.forEach(btn => btn.disabled = true);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '4myacc.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText.trim());
                    location.reload(); 
                } else {
                    alert('An error occurred. Please try again.');
                    buttonsInRow.forEach(btn => btn.disabled = false);
                }
            };
            xhr.send(`orderId=${encodeURIComponent(orderId)}&product=${encodeURIComponent(product)}&action=${encodeURIComponent(action)}`);
        }
    });
});

</script>

</body>
</html>
