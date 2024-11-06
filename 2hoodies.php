<!DOCTYPE html>
<html lang="en">
<head>
<title>Brigade Clothing</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css"åç href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="styles/categories_styles.css">
<link rel="stylesheet" type="text/css" href="styles/categories_responsive.css">
</head>

<body>

<div class="super_container">

	<!-- Header -->

	<header class="header trans_300">	

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="1index2.php"><img src="assets/1.png"></a>
						</div>
						<nav class="navbar">
							<ul class="navbar_menu">
								<li><a href="index.html">home</a></li>
								<li><a href="3shop.php">shop</a></li>
								<li><a href="3new.php">new</a></li>
								<li><a href="3onsale.php">on sale</a></li>
							</ul>
							<ul class="navbar_user">
								<li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
								<li><a href="4myacc.php"><i class="fa fa-user" aria-hidden="true"></i></a></li>
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

	<div class="container product_section_container">
		<div class="row">
			<div class="col product_section clearfix">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="1index2.php">Home</a></li>
						<li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Hoodies</a></li>
					</ul>
				</div>

				<!-- Sidebar -->

				<div class="sidebar">

					<!-- Price Range Filtering -->
					<div class="sidebar_section">
						<div class="sidebar_title">
							<h5>Filter by Price</h5>
						</div>
						<p>
							<input type="text" id="amount" readonly style="border:0; color:#FF6503; font-weight:bold;">
						</p>
						<div id="slider-range"></div>
						<div class="filter_button"><span>filter</span></div>
					</div>
					<div class="sidebar_section">
						<div class="sidebar_title">
							<h5>Sizes</h5>
						</div>
						<ul class="checkboxes">
							<li><i class="fa fa-square-o" aria-hidden="true"></i><span>S</span></li>
							<li class="active"><i class="fa fa-square" aria-hidden="true"></i><span>M</span></li>
							<li><i class="fa fa-square-o" aria-hidden="true"></i><span>L</span></li>
							<li><i class="fa fa-square-o" aria-hidden="true"></i><span>XL</span></li>
							<li><i class="fa fa-square-o" aria-hidden="true"></i><span>XXL</span></li>
						</ul>
					</div>


				</div>

				<!-- Main Content -->

				<div class="main_content">

					<!-- Products -->

					<div class="products_iso">
						<div class="row">
							<div class="col">

								<!-- Product Sorting -->

								<div class="product_sorting_container product_sorting_container_top">
									<ul class="product_sorting">
										<li>
											<span class="type_sorting_text">Default Sorting</span>
											<i class="fa fa-angle-down"></i>
											<ul class="sorting_type">
												<li class="type_sorting_btn" data-isotope-option='{ "sortBy": "original-order" }'><span>Default Sorting</span></li>
												<li class="type_sorting_btn" data-isotope-option='{ "sortBy": "price" }'><span>Price</span></li>
												<li class="type_sorting_btn" data-isotope-option='{ "sortBy": "name" }'><span>Product Name</span></li>
											</ul>
										</li>
								
								</div>

								<!-- Product Grid -->

								<div class="product-grid">

									<!-- Product 1 -->

									<div class="product-item hoodies" data-id="12">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="images/product_1.png" alt="">
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="single.html">Brigade Clothing - What Ever (Pullovers)</a></h6>
                                                <div class="product_price">₱1500.00</div>
                                            </div>
                                        </div>
                                        <div class="red_button add_to_cart_button"><a href="#" class="add-to-cart">add to cart</a></div>
                                    </div>

									<!-- Product 2 -->

									<div class="product-item hoodies" data-id="13">
                                        <div class="product discount product_filter">
                                            <div class="product_image">
                                                <img src="images/product_1.png" alt="">
                                            </div>
                                            <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>SALE</span></div>
                                            <div class="product_info">
                                                <h6 class="product_name"><a href="single.html">Brigade Clothing - You're Hired (Pullovers)</a></h6>
                                                <div class="product_price">₱1500.00<span>₱1700.00</span></div>
                                            </div>
                                        </div>
                                        <div class="red_button add_to_cart_button"><a href="#" class="add-to-cart">add to cart</a></div>
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


<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="js/categories_custom.js"></script>
<script>
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    function updateCart() {
        const cartCountElement = document.getElementById('checkout_items');
        cartCountElement.textContent = cartItems.reduce((total, item) => total + (item.quantity || 1), 0);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default anchor click behavior
            const productItem = button.closest('.product-item');
            const productId = productItem.getAttribute('data-id');
            const productName = productItem.querySelector('.product_name a').textContent;
            const productImage = productItem.querySelector('.product_image img').src;
            const productPrice = productItem.querySelector('.product_price').textContent;

            // Check if item already exists in the cart
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex > -1) {
                // Increase quantity if it already exists
                cartItems[existingItemIndex].quantity += 1;
            } else {
                // Add new item to cart with a default quantity of 1
                cartItems.push({ id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 });
            }

            updateCart(); // Update the cart display
            alert(`${productName} has been added to your cart!`);
        });
    });

    // Update cart count on page load
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

</body>

</html>
