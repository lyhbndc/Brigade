<?php
session_start(); 
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Brigade Clothing</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Brigade">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
	<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
	<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
	<link rel="stylesheet" type="text/css" href="styles/responsive.css">
</head>

<body>
<div class="loading-page" id="loadingPage">
        <img src="assets/1.png" alt="Logo" class="logo" id="logo">
    </div>
<div class="super_container">
	<header class="header trans_300">
		<div class="top_nav">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="top_nav_left"></div>
					</div>
				</div>
			</div>
		</div>

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
										<?php if ($user): ?>
											<a class="dropdown-item" href="4myacc.php">Account</a>
											<a class="dropdown-item" href="4recentorders.php">Recent Orders</a>
											<a class="dropdown-item" href="logout.php">Logout</a>
										<?php else: ?>
											<a class="dropdown-item" href="4login.php">Sign In</a>
											<a class="dropdown-item" href="7adminlogin.php">Admin</a>
										<?php endif; ?>
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
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item has-children">
					<a href="4myacc.php">
						My Account
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
						<li><a href="4login.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
						<li><a href="4signup.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li>
					</ul>
				</li>
				<li class="menu_item"><a href="1homepage.php">home</a></li>
				<li class="menu_item"><a href="3shop.php">shop</a></li>
				<li class="menu_item"><a href="3new.php">new</a></li>
				<li><a href="4recentorders.php">Recent Orders</a></li>
				<li><a href="logout.php" class="logout">Logout</a><li></li>
			</ul>
		</div>
	</div>

	<!-- Slider -->

	<div class="main_slider" style="background-image:url(assets/bg.png)">
		<div class="container fill_height">
			<div class="row align-items-center fill_height"></div>
		</div>
	</div>

	<!-- Banner -->

	<div class="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(assets/h.png)">
						<div class="banner_category">
							<a href="#" class="disabled-link" style="pointer-events: none;">HOODIES</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(assets/t.png)">
						<div class="banner_category">
							<a href="#" class="disabled-link" style="pointer-events: none;">TEES</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(assets/s.png)">
						<div class="banner_category">
							<a href="#" class="disabled-link" style="pointer-events: none;">SHORTS</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- NEW ARRIVALS-->
	<div class="new_arrivals">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="section_title new_arrivals_title">
						<h2>WHAT'S NEW</h2>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col text-center">
					<div class="new_arrivals_sorting">
						<ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
							<li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked" data-filter="*">all</li>
							<li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".hoodies">HOODIES</li>
							<li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".tees">TEES</li>
							<li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".shorts">SHORTS</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
					<div class="product-item tees" data-id="1001">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1001/1front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1001.php">Brigade Clothing - Let's Get High</a></h6>
                                                <div class="product_price">₱700.00<span>₱750.00</span></div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="product-item tees" data-id="1003">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1003/3front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1003.php">Brigade Clothing - Allergic (White)</a></h6>
                                                <div class="product_price">₱400.00<span>₱750.00</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-item shorts" data-id="1005">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1005/5front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1005.php">Brigade Clothing - Nectar</a></h6>
                                                <div class="product_price">₱380.00<span>₱500.00</span></div>
                                            </div>
                                        </div>
                        
                                    </div>

                                    <div class="product-item shorts" data-id="1007">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1007/7front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1007.php">Brigade Clothing - Sting</a></h6>
                                                <div class="product_price">₱300.00<span>₱500.00</span></div>
                                            </div>
                                        </div>
                                        
                                    </div>

                        <div class="product-item hoodies" data-id="1008">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1008/8front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1007.php">Brigade Clothing - Daily (Longsleeve)</a></h6>
                                                <div class="product_price">₱850.00<span>₱900.00</span></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="product-item hoodies" data-id="1009">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="items/images/1009/9front.png" alt="">
                                            </div>
                                            <div class="favorite favorite_left"></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="items/1009.php">Brigade Clothing - Warm Up</a></h6>
                                                <div class="product_price">₱1500.00<span>₱1700.00</span></div>
                                            </div>
                                        </div>
                                       
                                    </div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>

	<video autoplay muted loop>
		<source src="assets/1102.mp4" type="video/mp4">
		Your browser does not support the video tag.
	</video>

	<div class="best_sellers">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="section_title new_arrivals_title">
						<h2>BEST SELLERS</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="product_slider_container">
						<div class="owl-carousel owl-theme product_slider">
							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1002">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1002/2front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1002.php">Brigade Clothing - On The Grind</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>

							<!-- Slide 2 -->

							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1004">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1004/4front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1004.php">Brigade Clothing - Summer Heist</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>

							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1006">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1006/6front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1006.php">Brigade Clothing - Bay Area</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>

							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1003">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1003/3front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1003.php">Brigade Clothing - Allergic (White)</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>

							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1009">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1009/9front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1009.php">Brigade Clothing - Warm Up</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>

							<div class="owl-item product_slider_item">
								<div class="product-item" data-id="1010">
									<div class="product discount">
										<div class="product_image">
											<img src="items/images/1010/10front.png" alt="">
										</div>
										<div class="favorite favorite_left"></div>
										<div class="product_info">
											<h6 class="product_name"><a href="items/1010.php">Brigade Clothing - Earth</a></h6>
											<div class="product_price">P700.00<span>750.00</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="product_slider_nav_left product_slider_nav d-flex align-items-center justify-content-center flex-column">
							<i class="fa fa-chevron-left" aria-hidden="true"></i>
						</div>
						<div class="product_slider_nav_right product_slider_nav d-flex align-items-center justify-content-center flex-column">
							<i class="fa fa-chevron-right" aria-hidden="true"></i>
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

<script>
      
	window.addEventListener('load', function() {
		const loadingPage = document.getElementById('loadingPage');
		const content = document.getElementById('content');
		const logo = document.getElementById('logo');
		
	   
		setTimeout(() => {
			logo.classList.add('zoom-fade'); 
		}, 2000); 

	  
		setTimeout(() => {
			loadingPage.style.display = 'none'; 
			content.style.display = 'block';   
		}, 3000); 
	});
</script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/custom.js"></script>

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
 { img: "items/images/1010/i1.png", alt: "10", name: "Earth", href: "items/1010.php" },
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