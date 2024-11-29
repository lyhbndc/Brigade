<!DOCTYPE html>
<html lang="en">
<head>
<title>Brigade Clothing - Bay Area</title>
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
							<a href="1index.php"><img src="images/1.png"></a>
						</div>
						<nav class="navbar">
                    <ul class="navbar_menu">
                        <li><a href="../1index.php">home</a></li>
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
								<a class="dropdown-item" href="../4myacc.php">Account</a>
								<a class="dropdown-item" href="../4recentorders.php">Recent Orders</a>
								<a class="dropdown-item" href="../logout.php">Logout</a>
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
						<li><a href="../1index.php">Home</a></li>
						<li><a href="../2shorts.php"><i class="fa fa-angle-right" aria-hidden="true"></i>Shorts</a></li>
						<li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Bay Area</a></li>
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
									<li class="active"><img src="images\1006\t1.png" alt="" data-image="images/1006/1.png"></li>
									<li ><img src="images\1006\t2.png" alt="" data-image="images/1006/2.png"></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-9 image_col order-lg-2 order-1">
							<div class="single_product_image">
								<div class="single_product_image_background" style="background-image:url(images/1006/1.png)"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="product_details">
					<div class="product_details_title">
						<h2>BRIGADE CLOTHING - Bay Area</h2>
						<p>Elevate your casual style with the Brigade Clothing Mesh Shorts, available in sizes from S to XXL to ensure a perfect fit for everyone. Crafted with care and precision, these unisex shorts are locally made with pride, offering superior comfort and durability for everyday wear. Whether you're lounging at home or heading out for an active day, these mesh shorts provide the breathability and flexibility you need.</p>
					</div>
					<div class="original_price">₱750.00</div>
					<div class="product_price">₱700.00</div>
					<div class="product_size">
						<br>
						<span>Select Size:</span>
						<div class="size-options">
							<div class="size-option" data-size="s">Small</div>
							<div class="size-option" data-size="m">Medium</div>
							<div class="size-option" data-size="l">Large</div>
							<div class="size-option" data-size="xl">XL</div>
							<div class="size-option" data-size="2xl">2XL</div>
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
				<div class="red_button add_to_cart_button"><a href="#">add to cart</a></div>
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
									<h2>Lightweight, Breathable Comfort with Bold Design</h2>
									<p>Made from lightweight, breathable fabric, these shorts are designed to keep you cool and comfortable in any setting. The screen-printed design adds a bold and unique touch, making it clear that you take pride in what you wear. Plus, each pair comes with a free sticker to personalize your gear further.</p>
								</div>
							</div>
							<div class="col-lg-5 offset-lg-2 desc_col">
								<div class="tab_image">
									<img src="images\1006\i1.png" alt="">
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
									<img src="images/sg-11134201-22120-xm74r6prjykvd8.webp" alt="">
									<div class="others">
								<p>COLOR:<span></span></p>
								<p>SIZE:<span>S, M, L, Xl, XXL</span></p>
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
					<a href="../1index.php"><img src="images/Untitled design.png" class="footer-logo"></a>
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
					<li class="p-b-10"><a href="../1index.php" class="stext-107 cl7 footer-link hov-cl1 trans-04">Home</a></li>
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
    // Initialize the cart items from localStorage
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    // Function to update the cart count in the header
    function updateCartCount() {
        const cartCountElement = document.getElementById('checkout_items');
        cartCountElement.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
    }

    // Add event listener to "Add to Cart" button
    document.querySelector('.add_to_cart_button a').addEventListener('click', function(event) {
        event.preventDefault();

        // Product details
        const productId = "1";  // This could be dynamically set based on your product data
        const productName = document.querySelector('.product_details_title h2').textContent;
        const productPrice = document.querySelector('.product_price').textContent.trim();
        const productImage = document.querySelector('.single_product_image_background').style.backgroundImage.replace(/url\(["']?(.+?)["']?\)/, '$1');
        const quantity = parseInt(document.getElementById('quantity_value').textContent);

        // Check if the item is already in the cart
        const existingItemIndex = cartItems.findIndex(item => item.id === productId);
        if (existingItemIndex > -1) {
            // Increase quantity if item exists
            cartItems[existingItemIndex].quantity += quantity;
        } else {
            // Add new item
            cartItems.push({ id: productId, name: productName, price: productPrice, image: productImage, quantity });
        }

        // Update localStorage and cart count
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCartCount();
        alert(`${productName} has been added to your cart!`);
    });

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', updateCartCount);
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
 { img: "images/10010/i1.png", alt: "10", name: "Earth", href: "10010.php" },
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