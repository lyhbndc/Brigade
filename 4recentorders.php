<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = $_SESSION['user'];
$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user'])) {
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
        //echo "Order ";
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
                echo "Order #$orderId Cancelled!";
                exit();
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
                echo "Order #$orderId Received! Thank you`.";
                exit();
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
                echo "Order #$orderId Return!`.";
                exit();
            } else {
                echo "Error inserting order into `refund_order`: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Order not found.";
        }
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
    <link rel="stylesheet" type="text/css" href="styles/recent.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
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
                                    <li><a href="logout.php" class="logout">Logout</a></li>
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
            <th>Size</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>

    <!-- Add buttons inside the table row -->
    <tbody>
        <?php if ($orderResult && mysqli_num_rows($orderResult) > 0): ?>
            <?php while ($orderRow = mysqli_fetch_assoc($orderResult)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($orderRow['OrderID']); ?></td>
                    <td><?php echo htmlspecialchars($orderRow['Product']); ?></td>
                    <td><?php echo htmlspecialchars($orderRow['Quantity']); ?></td>
                    <td><?php echo htmlspecialchars($orderRow['Size']); ?></td>
                    <td>
                        <?php if ($orderRow['Status'] == "Shipped"): ?>
                            <span class="badge badge-success"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                        <?php else: ?>
                            <span class="badge badge-warning"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($orderRow['Total']); ?></td>
                    <td><?php echo htmlspecialchars($orderRow['Date']); ?></td>
                    <td><?php echo htmlspecialchars($orderRow['Address']); ?></td>
                    <td>
                        <div class="button-container">
                            <button class="btn btn-success btn-sm action-button" data-order-id="<?php echo $orderRow['OrderID']; ?>" data-product="<?php echo $orderRow['Product']; ?>" data-action="Received" name ="Received">Received</button>
                            <button class="btn btn-warning btn-sm action-button" data-order-id="<?php echo $orderRow['OrderID']; ?>" data-product="<?php echo $orderRow['Product']; ?>" data-action="Refund">Refund</button>
                            <button class="btn btn-danger btn-sm action-button" data-order-id="<?php echo $orderRow['OrderID']; ?>" data-product="<?php echo $orderRow['Product']; ?>" data-action="Cancel">Cancel</button>
                        </div>
                    </td>
                </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No orders found</td>
        </tr>
    <?php endif; ?>
</tbody>
</div>
    </table>                
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

<style>
    /* Center-align text in table headers */
    .table th {
        text-align: center;
    }

    /* Space between buttons */
    .button-container .action-button {
        margin: 0 5px; /* Horizontal space between buttons */
    }
    
    /* Center-align buttons in cell */
    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Additional padding for table cells */
    .table td, .table th {
        padding: 35px 40px; /* Increase cell padding for better readability */
    }
</style>

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
            xhr.open('POST', '4recentorders.php', true);
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
