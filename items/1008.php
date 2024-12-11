<?php
session_start(); 
$user = $_SESSION['user'];
$conn = mysqli_connect("localhost", "root", "", "brigade");

$productId = isset($_GET['id']) ? $_GET['id'] : 1008;  

if ($productId > 0) {
    // Fetch product details based on the product ID
    $sql = "SELECT id, name, image, category, price, small_stock, medium_stock, large_stock, xl_stock, xxl_stock, xxxl_stock FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);  // Bind the productId to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $isOutOfStock = ($product['small_stock'] == 0 && $product['medium_stock'] == 0 && $product['large_stock'] == 0 && $product['xl_stock'] == 0 && $product['xxl_stock'] == 0 && $product['xxxl_stock'] == 0);
    } else {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $product['name']; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="ins/bootstrap4/bootstrap.min.css">
<link href="ins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="ins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="ins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="ins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" href="ins/themify-icons/themify-icons.css">
<link rel="stylesheet" type="text/css" href="ins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="ins/items.css">
<link rel="stylesheet" type="text/css" href="ins/single_responsive.css">
<style>
	.add-to-cart {
    width: 400px; /* Width of the button */
    margin-left: 19px; /* Left margin */
    margin-top: auto; /* Top margin for flex alignment */
    font-size: 12px !important; /* Font size */
    height: 50px; /* Set height for the button */
    border-radius: 20px; /* Rounded corners */
    background-color: black; /* Background color */
    color: white; /* Text color */
    border: none; /* Remove default border */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s, transform 0.2s ease-in-out; /* Smooth transition for background and scaling */
    text-align: center; /* Center the text */
}

/* Hover effect */
.add-to-cart:hover {
    background-color: gray; /* Change background color on hover (darker orange) */
    transform: scale(1.05); /* Slightly enlarge the button */
}

/* Optional: Add a focus state to improve accessibility */
.add-to-cart:focus {
    outline: none; /* Remove default outline */
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.5); /* Add a glow effect when focused */
}

	</style>
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
							<a href="../1homepage.php"><img src="images/1.png"></a>
						</div>
						<nav class="navbar">
                    <ul class="navbar_menu">
                        <li><a href="../1homepage.php">home</a></li>
                        <li><a href="../3shop.php">shop</a></li>
                        <li><a href="../3new.php">new</a></li>
                        
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
										<?php if ($user): ?>
											<a class="dropdown-item" href="../4myacc.php">Account</a>
											<a class="dropdown-item" href="../4recentorders.php">Recent Orders</a>
											<a class="dropdown-item" href="../logout.php">Logout</a>
										<?php else: ?>
											<a class="dropdown-item" href="../4login.php">Sign In</a>
											<a class="dropdown-item" href="../7adminlogin.php">Admin</a>
										<?php endif; ?>
									</div>
								</li>
                        
                        <li class="checkout">
                            <a href="../3cart.php">
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

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="../1homepage.php">Home</a></li>
						<li><a href="../2tees.php"><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $product['category']; ?></a></li>
						<li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $product['name']; ?> </a></li>
					</ul>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-lg-7">
				<div class="single_product_pics">
					<div class="row">
						<div class="col-lg-3 thumbnails_col order-lg-1 order-2">
							<div class="single_product_thumbnails">
								<ul>
									<li class="active"><img src="images\1008\t1.png" alt="" data-image="images/1008/1.png"></li>
									<li ><img src="images\1008\t2.png" alt="" data-image="images/1008/2.png"></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-9 image_col order-lg-2 order-1">
							<div class="single_product_image">
								<div class="single_product_image_background" style="background-image:url(images/1008/1.png)"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="product_details">
					<div class="product_details_title">
					<h2><?php echo $product['name']; ?></h2>
						<p>The Brigade Clothing offers the perfect blend of comfort, style, and bold expression. Designed as a unisex basic T-shirt, this versatile piece is available in sizes ranging from S to XXL, ensuring a fit for everyone. Whether you're lounging or out with friends, this shirt adds an effortlessly cool vibe to your wardrobe.</p>
					</div>
					<div class="original_price">₱950.00</div>
					<p class="product_price"><?php echo '₱' . $product['price']; ?></p>
					<div class="product_size">
						<br>
						<span>Select Size:</span>
						<div class="size-options">
							<button class="size-option" data-size="small">Small</button>
							<button class="size-option" data-size="medium">Medium</button>
							<button class="size-option" data-size="large">Large</button>
							<button class="size-option" data-size="xl">XL</button>
							<button class="size-option" data-size="xxl">XXL</button>
							<button class="size-option" data-size="xxxl">XXXL</button>
						</div>
					</div>
					<div class="quantity d-flex flex-column flex-sm-row align-items-sm-center">
						<span>Quantity:</span>
						<div class="quantity_selector">
							<span class="minus"><i class="fa fa-minus" aria-hidden="true"></i></span>
							<span id="quantity_value">1</span>
							<span class="plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
						</div>
						<div class="product_favorite d-flex flex-column align-items-center justify-content-center"></div>
					</div>
				</div><br>
				<?php if ($isOutOfStock): ?>
					<button class="add-to-cart" disabled>Out of Stock</button>
				<?php else: ?>
					<button 
						class="add-to-cart" 
						data-id="<?php echo $product['id']; ?>" 
						data-image="<?php echo 'http://localhost/Brigade/uploads/' . $product['image']; ?>">Add to Cart</button>
				<?php endif; ?>
			</div>
			</div>
		</div>
	</div>

	<!-- Tabs -->

	<div class="tabs_section_container">

		<div class="container">
			<div class="row">
				<div class="col">
					<div class="tabs_container">
						<ul class="tabs d-flex flex-sm-row flex-column align-items-left align-items-md-center justify-content-center">
							<li class="tab active" data-active-tab="tab_1"><span>Description</span></li>
							<li class="tab" data-active-tab="tab_2"><span>Additional Information</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">

					<!-- Tab Description -->

					<div id="tab_1" class="tab_container active">
						<div class="row">
							<div class="col-lg-5 desc_col">
								<div class="tab_title">
									<h4>Description</h4>
								</div>
								<div class="tab_text_block">
									<h2>Premium Quality and Bold Design</h2>
									<p>Crafted locally with pride, each T-shirt is made from a durable and breathable blend of 80% cotton and 20% polyester. The fabric combination ensures a soft, smooth feel against the skin while providing lasting quality, making it a perfect addition to your everyday essentials. </p>
								</div>
								<div class="tab_image">
									<img src="images\1008\i1.png" alt="">
								</div>
							</div>
							<div class="col-lg-5 offset-lg-2 desc_col">
								<div class="tab_image">
									<img src="images\1008\i2.png" alt="">
								</div>
								<div class="tab_text_block">
									<h2>A Statement of Style and Individuality</h2>
									<p>To make this T-shirt even more special, a free sticker is included, giving you the chance to personalize your gear further. With its locally made craftsmanship and high-quality design, the Brigade Clothing is not just a piece of clothing—it's a statement. Get yours now and wear it with pride!</p>
								</div>

							</div>
						</div>
					</div>

					<!-- Tab Additional Info -->

					<div id="tab_2" class="tab_container">
						<div class="row">
							<div class="col additional_info_col">
								<div class="tab_title additional_info_title">
									<h4>Additional Information</h4>
								</div>
                                <div class="col-lg-8 offset-lg-2 desc_col">
								<div class="tab_image">
									<img src="images\sg-11134201-22120-xm74r6prjykvd8.webp" alt="">
									<div class="others">
								<p>COLOR:<span>Black</span></p>
								<p>SIZE:<span>S, M, L, Xl, XXL, 3XL</span></p>
									</div>
                                </div>
							</div>
						</div>
					</div>

						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	<!-- Benefit -->

	<div class="benefit">
		<div class="container">
			<div class="row benefit_row">
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>shipping nationwide</h6>
							<p>Fast and reliable.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>cash on delivery</h6>
							<p>Pay conveniently at your doorstep.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>45 days return</h6>
							<p>Hassle-free returns within 45 days.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>open everyday</h6>
							<p>10:00AM - 8:00PM</p>
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
					<a href="../1homepage.php"><img src="images/Untitled design.png" class="footer-logo"></a>
				</h4>
				<p class="stext-107 cl7 size-201">
					Any questions? Let us know in store at Brigade Clothing, Brgy. Sta Ana, Taytay, Rizal.
				</p>
			</div>
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Company</h7>
	
				<ul>
					<li class="p-b-10"><a href="../5about.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">About Brigade</a></li>
					<li class="p-b-10"><a href="../5features.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Features</a></li>
				</ul>
			</div>
			<div class="col-sm-6 col-lg-3 p-b-50">
				<br>
				<h7 class="stext-301 cl0 p-b-30" style="font-size: 22px; font-weight: 600;">Main Menu</h7>
				<ul>
					<li class="p-b-10"><a href="../1homepage.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Home</a></li>
					<li class="p-b-10"><a href="../3shop.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Shop</a></li>
					<li class="p-b-10"><a href="../3new.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">New</a></li>
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

<script src="ins/jquery-3.2.1.min.js"></script>
<script src="ins/bootstrap4/popper.js"></script>
<script src="ins/bootstrap4/bootstrap.min.js"></script>
<script src="ins/Isotope/isotope.pkgd.min.js"></script>
<script src="ins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="ins/easing/easing.js"></script>
<script src="ins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="ins/single_custom.js"></script>
<script>
    const cartKey = `cartItems_${<?php echo json_encode($user); ?>}`;
	let cartItems = JSON.parse(localStorage.getItem(cartKey)) || [];

	// Update cart item count
	function updateCart() {
		const cartCountElement = document.getElementById('checkout_items');
		if (cartCountElement) {
			cartCountElement.textContent = cartItems.length;
		}
	}

	// Add to Cart Logic
	document.querySelector('.add-to-cart').addEventListener('click', function (event) {
		const productId = event.target.getAttribute('data-id');
		const productImage = event.target.getAttribute('data-image'); // Get the image from the button's data attribute
		const productName = document.querySelector('h2').textContent.trim(); // Product name from the page
		const productPrice = document.querySelector('.product_price').textContent.trim(); // Correct class for product price
		const selectedSize = document.querySelector('.size-option.active')?.getAttribute('data-size'); // Get the active size
		const quantity = parseInt(document.getElementById('quantity_value').textContent, 10); // Get selected quantity

		if (!selectedSize) {
			alert('Please select a size before adding to cart.');
			return;
		}

		// Check if the product is already in the cart
		const existingItemIndex = cartItems.findIndex(item => item.id === productId && item.size === selectedSize);

		if (existingItemIndex > -1) {
			cartItems[existingItemIndex].quantity += quantity;
		} else {
			cartItems.push({
				id: productId,
				name: productName,
				price: productPrice,
				size: selectedSize,
				quantity: quantity,
				image: productImage // Use the image from the database
			});
		}

		localStorage.setItem(cartKey, JSON.stringify(cartItems));
		alert(`${quantity} ${productName} (${selectedSize}) has been added to your cart!`);
		updateCart();
	});

	// Update the size selection when clicked
	document.querySelectorAll('.size-option').forEach(function (button) {
		button.addEventListener('click', function () {
			document.querySelectorAll('.size-option').forEach(function (btn) {
				btn.classList.remove('active');
			});
			button.classList.add('active');
		});
	});

	// Quantity Selector Logic
	function incrementQuantity() {
		let currentQuantity = parseInt(quantityElement.textContent, 10);
		quantityElement.textContent = currentQuantity + 1;
	}

	function decrementQuantity() {
		let currentQuantity = parseInt(quantityElement.textContent, 10);
		if (currentQuantity > 1) {
			quantityElement.textContent = currentQuantity - 1;
		}
	}

	document.querySelector('.quantity_selector .plus').onclick = incrementQuantity;
	document.querySelector('.quantity_selector .minus').onclick = decrementQuantity;

	// Initialize cart count on page load
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

<script>
    const items = [
 { img: "images/1001/i1.png", alt: "1", name: "Let's Get High", href: "1001.php" },
 { img: "images/1002/i1.png", alt: "2", name: "On The Grind", href: "1002.php"},
 { img: "images/1003/i1.png", alt: "3", name: "Allergic", href: "1003.php" },
 { img: "images/1004/i1.png", alt: "4", name: "Summer Heist", href: "1004.php" },
 { img: "images/1005/i1.png", alt: "5", name: "Nectar", href: "1005.php" },
 { img: "images/1006/i1.png", alt: "6", name: "Bay Area", href: "1006.php" },
 { img: "images/1007/i1.png", alt: "7", name: "Sting", href: "1007.php" },
 { img: "images/1008/i1.png", alt: "8", name: "Daily", href: "1008.php" },
 { img: "images/1009/i1.png", alt: "9", name: "Warm Up", href: "1009.php" },
 { img: "images/1010/i1.png", alt: "10", name: "Earth", href: "1010.php" },
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
    document.addEventListener("DOMContentLoaded", () => {
        const sizeOptions = document.querySelectorAll(".size-option");
        let selectedSize = null;

        sizeOptions.forEach(option => {
            option.addEventListener("click", () => {
                // Remove 'active' class from all size options
                sizeOptions.forEach(opt => opt.classList.remove("active"));
                
                // Add 'active' class to the clicked option
                option.classList.add("active");

                // Record the selected size
                selectedSize = option.getAttribute("data-size");
                console.log("Selected size:", selectedSize); // Replace with desired logic
            });
        });
    });
</script>
</body>
</html>