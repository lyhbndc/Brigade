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

$firstname = ""; // Initialize variables to prevent undefined warnings
$lastname = "";
$email = "";
$address = "";
$city = "";
$fullname = "";

$query = "SELECT * FROM user WHERE Username = '$user'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $firstname = $row["FirstName"];
        $lastname = $row["LastName"];
        $city = $row["City"];
        $email = $row["Email"];
        $address = $row["Address"];
        $fullname = $row["FirstName"] . ' ' . $row["LastName"];
    }
}

// Include database connection (adjust the connection as per your setup)
include 'db_connection.php';

// Handle profile update
if (isset($_POST['update_profile'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);

    // Only update non-empty fields
    $updateQuery = "UPDATE user SET";
    $fieldsToUpdate = [];

    if (!empty($firstname)) $fieldsToUpdate[] = " FirstName = '$firstname'";
    if (!empty($lastname)) $fieldsToUpdate[] = " LastName = '$lastname'";
    if (!empty($email)) $fieldsToUpdate[] = " Email = '$email'";
    if (!empty($address)) $fieldsToUpdate[] = " Address = '$address'";
    if (!empty($city)) $fieldsToUpdate[] = " City = '$city'";

    if (!empty($fieldsToUpdate)) {
        $updateQuery .= implode(", ", $fieldsToUpdate) . " WHERE Username = '$user'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "Profile updated successfully!";
            header("Refresh:0"); // Refresh the page to show updated info
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
}

// Handle password update
if (isset($_POST['update_password'])) {
    $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $reenterPassword = mysqli_real_escape_string($conn, $_POST['reenter_password']);

    // Check current password
    $userCheckQuery = "SELECT Password FROM user WHERE Username = '$user'";
    $result = mysqli_query($conn, $userCheckQuery);
    $row = mysqli_fetch_assoc($result);

    if ($row['Password'] === $currentPassword) {
        // Validate password criteria
        if ($newPassword === $reenterPassword &&
            strlen($newPassword) >= 8 &&
            preg_match('/[A-Z]/', $newPassword) &&
            preg_match('/\d/', $newPassword) &&
            preg_match('/[\W_]/', $newPassword)) {

            // Update password in the database (without hashing)
            $updatePasswordQuery = "UPDATE user SET Password = '$newPassword' WHERE Username = '$user'";
            if (mysqli_query($conn, $updatePasswordQuery)) {
                echo "Password updated successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid password. Ensure it matches criteria.";
        }
    } else {
        echo "Current password is incorrect.";
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
    <link rel="stylesheet" type="text/css" href="styles/acc.css">
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
        <br><br><br>
        <div class="title">
        <div class="account-container">
    <h1>My Account</h1>
    
    <!-- Account Details Section -->
    <div class="account-profile" id="accountDetails">
        <div class="user-details">
            <div class="profile-header">
                <!-- Profile Picture -->
                <img src="assets\ano.webp" class="profile-pic">
                
                <!-- User Details -->
                <div class="user-info">
                    <p><strong>Name:</strong><br><span id="name"><?php echo $fullname; ?></span></p>
                    <p><strong>Email:</strong><br><span id="email"><?php echo $email; ?></span></p>
                    <p><strong>Address:</strong><br><span id="address"><?php echo $address; ?></span></p>
                    <p><strong>City:</strong><br><span id="city"><?php echo $city; ?></span></p>
                    <p><strong>Country:</strong><br><span>Philippines</span></p>
                </div>
            </div>
        </div>
        <button class="recent-order-btn" onclick="editProfile()">Edit Profile</button>
        <button class="recent-order-btn" onclick="window.location.href='4recentorders.php';">Recent Orders</button>
        <button class="recent-order-btn" onclick="window.location.href='logout.php';">Logout</button>
    </div>

    <!-- Edit Profile Form Section -->
    <div class="edit-profile-form" id="editProfileForm">
    <form method="post">
    <!-- Account Information -->
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" id="editFirstname" value="<?php echo htmlspecialchars($firstname); ?>"><br>

    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" id="editLastname" value="<?php echo htmlspecialchars($lastname); ?>"><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="editEmail" value="<?php echo htmlspecialchars($email); ?>"><br>

    <label for="address">Address:</label>
    <input type="text" name="address" id="editAddress" value="<?php echo htmlspecialchars($address); ?>"><br>

    <label for="city">City:</label>
    <input type="text" name="city" id="editCity" value="<?php echo htmlspecialchars($city); ?>"><br>

    <button type="submit" name="update_profile">Save Changes</button>
</form>


        <!-- Update Password Section -->
        <button id="updatePasswordButton" onclick="togglePasswordUpdate()">Update Password</button>
        <div id="passwordUpdateSection" style="display: none;">
    <form method="post">
        <label for="current_password">Enter Current Password:</label>
        <input type="password" name="current_password" id="currentPassword" required><br>

        <label for="new_password">Enter New Password:</label>
        <input type="password" name="new_password" id="newPassword" required><br>

        <label for="reenter_password">Re-enter Password:</label>
        <input type="password" name="reenter_password" id="reenterPassword" required><br>

        <button type="submit" name="update_password">Save New Password</button>
    </form>
</div>

        
        <button type="button" onclick="cancelEdit()">Cancel</button>
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

<script>//UPDATE PROFILE
    function editProfile() {
        // Hide the account details and show the edit form
        document.getElementById('accountDetails').style.display = 'none';
        document.getElementById('editProfileForm').style.display = 'block';
    }

    function cancelEdit() {
        // Hide the edit form and show the account details again
        document.getElementById('editProfileForm').style.display = 'none';
        document.getElementById('accountDetails').style.display = 'block';
    }
</script>

<script> //UPDATE PASSWORD

    function togglePasswordUpdate() {
        const section = document.getElementById("passwordUpdateSection");
        const button = document.getElementById("updatePasswordButton");
        section.style.display = section.style.display === "none" ? "block" : "none";
        button.textContent = section.style.display === "none" ? "Update Password" : "Cancel Update";
    }

    // Real-time password validation
    const newPassword = document.getElementById("newPassword");
    const reenterPassword = document.getElementById("reenterPassword");
    const passwordCriteria = document.getElementById("passwordCriteria");
    const passwordMatchCheck = document.getElementById("passwordMatchCheck");
    const savePasswordButton = document.querySelector("button[type='submit'][name='update_password']");
    
    function validatePassword() {
        const value = newPassword.value;
        let criteriaMet = true;
        let criteriaMessage = '';

        if (value.length < 8) {
            criteriaMessage += "Password must be at least 8 characters long. ";
            criteriaMet = false;
        }
        if (!/[A-Z]/.test(value)) {
            criteriaMessage += "Password must contain at least one uppercase letter. ";
            criteriaMet = false;
        }
        if (!/\d/.test(value)) {
            criteriaMessage += "Password must contain at least one digit. ";
            criteriaMet = false;
        }
        if (!/[\W_]/.test(value)) {
            criteriaMessage += "Password must contain at least one special character. ";
            criteriaMet = false;
        }

        passwordCriteria.textContent = criteriaMessage ? criteriaMessage : "Password meets criteria.";
        passwordCriteria.style.color = criteriaMet ? "green" : "red";
        return criteriaMet;
    }

    newPassword.addEventListener("input", () => {
        const isPasswordValid = validatePassword();
        reenterPassword.disabled = !isPasswordValid; // Disable re-enter password field if criteria are not met
    });

    reenterPassword.addEventListener("input", () => {
        if (newPassword.value !== reenterPassword.value) {
            passwordMatchCheck.textContent = "Passwords do not match.";
            passwordMatchCheck.style.color = "red";
        } else {
            passwordMatchCheck.textContent = "Passwords match.";
            passwordMatchCheck.style.color = "green";
        }

        // Enable the save button if both passwords match and meet the criteria
        savePasswordButton.disabled = !(newPassword.value === reenterPassword.value && validatePassword());
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