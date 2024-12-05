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
                                <a href="1homepage.php"><img src="assets/1.png"></a>
                            </div>
                            <nav class="navbar">
                                <ul class="navbar_menu">
                                    <li><a href="1homepage.php">home</a></li>
                                    <li><a href="3shop.php">shop</a></li>
                                    <li><a href="3new.php">new</a></li>
                                    
                                </ul>
                                <ul class="navbar_user">
                                    <li class="dropdown">
                                        <a href="#" id="searchDropdown" role="button" onclick="toggleDropdown(event)" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu search-dropdown" id="searchDropdownMenu" style="display: none;">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="filterNames()">
                                            <ul id="nameList" class="name-list"></ul>
                                        </div>
                                    </li>
                                
                                    <!-- User Dropdown -->
                                    <li class="dropdown">
                                        <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="4myacc.php">Account</a>
                                            <a class="dropdown-item" href="4recentorders.php">Recent Orders</a>
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

        <br><br><br><br>

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
                    <?php elseif ($orderRow['Status'] == "Order Completed"): ?>
                        <span class="badge badge-secondary"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                    <?php else: ?>
                        <span class="badge badge-warning"><?php echo htmlspecialchars($orderRow['Status']); ?></span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($orderRow['Total']); ?></td>
                <td><?php echo htmlspecialchars($orderRow['Date']); ?></td>
                <td><?php echo htmlspecialchars($orderRow['Address']); ?></td>
                <td>
                    <div class="button-container">
                        <div>
                            <button 
                                class="btn btn-success btn-sm action-button" 
                                data-order-id="<?php echo $orderRow['OrderID']; ?>" 
                                data-product="<?php echo $orderRow['Product']; ?>" 
                                data-action="Received" 
                                name="Received"
                                <?php echo ($orderRow['Status'] == "Order Completed") ? 'disabled title="Order already completed"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Refunded") ? 'disabled title="Order Refund"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Cancelled") ? 'disabled title="Order already Cancelled"' : ''; ?>
                                
                                
                            >
                                Received
                            </button>
                        </div>
                        <div>
                            <button 
                                class="btn btn-warning btn-sm action-button" 
                                data-order-id="<?php echo $orderRow['OrderID']; ?>" 
                                data-product="<?php echo $orderRow['Product']; ?>" 
                                data-action="Refund"
                                <?php echo ($orderRow['Status'] == "Order Completed") ? 'disabled title="Order already completed"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Refunded") ? 'disabled title="Order Refund"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Cancelled") ? 'disabled title="Order already Cancelled"' : ''; ?>
                                >
                                Refund
                            </button>
                        </div>
                        <div>
                            <button 
                                class="btn btn-danger btn-sm action-button" 
                                data-order-id="<?php echo $orderRow['OrderID']; ?>" 
                                data-product="<?php echo $orderRow['Product']; ?>" 
                                data-action="Cancel"
                                <?php echo ($orderRow['Status'] == "Order Completed") ? 'disabled title="Order already completed"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Refunded") ? 'disabled title="Order Refund"' : ''; ?>
                                <?php echo ($orderRow['Status'] == "Cancelled") ? 'disabled title="Order already Cancelled"' : ''; ?>
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" class="text-center">No orders found</td>
        </tr>
    <?php endif; ?>
</tbody>

                        </table>            
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
                            <a href="1homepage.php"><img src="assets/Untitled design.png" class="footer-logo"></a>
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
                            <li class="p-b-10"><a href="1homepage.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Home</a></li>
                            <li class="p-b-10"><a href="3shop.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shop</a></li>
                            <li class="p-b-10"><a href="3new.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">New</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-b-50">
                        <br>
                        <h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Socials</h7>
                        <ul>
                            <li class="p-b-10"><a href="https://shopee.ph/brigadeclothing" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shopee</a></li>
                            <li class="p-b-10"><a href="https://www.lazada.com.ph/shop/brigade-clothing" class="stext-107 cl7 footer-link hov-cl1 trans-04">Lazada</a></li>
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
      <script>
    const items = [
        { img: "items/images/1001/i1.png", alt: "1", name: "Let's Get High", href: "items/1001.php" },
 { img: "items/images/1002/i1.png", alt: "2", name: "On The Grind", href: "items/1002.php"},
 { img: "items/images/1003/i1.png", alt: "3", name: "Allergic", href: "items/1003.php" },
 { img: "items/images/1004/i1.png", alt: "4", name: "Summer Heist", href: "items/1004.php" },
 { img: "items/images/1005/i1.png", alt: "5", name: "Nectar", href: "items/1005.php" },
 { img: "items/images/1006/i1.png", alt: "6", name: "Bay Area", href: "items/1006.php" },
 { img: "items/images/1007/i1.png", alt: "7", name: "Sting", href: "items/1007.php" },
 { img: "items/images/1008/i1.png", alt: "8", name: "Daily", href: "items/1008.php" },
 { img: "items/images/1009/i1.png", alt: "9", name: "Warm Up", href: "items/1009.php" },
 { img: "items/images/10010/i1.png", alt: "10", name: "Earth", href: "items/10010.php" },
];

const nameList = document.getElementById('nameList');
const searchInput = document.getElementById('searchInput');

function renderList(filteredItems) {
 nameList.innerHTML = ''; // Clear the list
 filteredItems.forEach(item => {
     const li = document.createElement('li');
     li.classList.add('name-item');
     li.innerHTML = `
         <a href="${item.href || '#'}" class="name-item-link" style="color: ${item.color || '#000'}">
                <img src="${item.img}" alt="${item.alt}" class="name-item-img">
                <span class="name-item-text">${item.name}</span>
            </a>
     `;
     nameList.appendChild(li);
 });
}

// Initial render
renderList(items);

function filterNames() {
 const searchValue = searchInput.value.toLowerCase();
 const filteredItems = items
     .filter(item => item.name.toLowerCase().includes(searchValue)) // Filter items
     .sort((a, b) => a.name.localeCompare(b.name)); // Sort filtered items alphabetically
 renderList(filteredItems); // Render the filtered and sorted list
}
searchInput.addEventListener('keyup', filterNames);

// Initialize the dropdown toggle behavior
function toggleDropdown(event) {
 const dropdownMenu = document.getElementById('searchDropdownMenu');
 const isExpanded = dropdownMenu.style.display === 'block';
 dropdownMenu.style.display = isExpanded ? 'none' : 'block';
}
function closeSearchDropdown() {
     const searchDropdownMenu = document.getElementById('searchDropdownMenu');
     searchDropdownMenu.style.display = 'none';
 }

 // Attach event listener to the user dropdown
 document.getElementById('userDropdown').addEventListener('click', function() {
     closeSearchDropdown(); // Close the search dropdown when the user dropdown is clicked
 });

 // Function to toggle the search dropdown
 function toggleSearchDropdown(event) {
     const dropdownMenu = document.getElementById('searchDropdownMenu');
     const isExpanded = dropdownMenu.style.display === 'block';
     dropdownMenu.style.display = isExpanded ? 'none' : 'block';
     
     // Close the user dropdown if it is open
     const userDropdownMenu = document.querySelector('.dropdown-menu-right');
     if (userDropdownMenu.style.display === 'block') {
         userDropdownMenu.style.display = 'none';
     }
 }
 </script>
</body>
</html>