<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: #111;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        nav .logo {
            width: 150px;
            height: auto;
            margin-top: 10px;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }

        .nav-links a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }

        .nav-links a:hover {
            background-color: #575757;
        }

        .nav-icons {
            display: flex;
            gap: 10px;
        }

        svg {
            padding: 14px 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.nav-icons {
    order: 0; 
    margin-left: auto; 
    display: flex; 
    gap: 1px;
}

            .nav-links {
                display: none; 
                flex-direction: column;
                width: 100%;
                position: absolute;
                top: 60px; 
                left: 0;
                background-color: #111;
                padding: 10px 0; 
            }

            .nav-links.mobile-active {
                display: flex; 
            }

            .hamburger {
                display: block; 
                cursor: pointer;
                font-size: 40px;
                color: white;
            }
        }


        @media (min-width: 769px) {
            .hamburger {
                display: none; 
            }
        }

        .header img {
            width: 100%;
            height: auto;
        }

        .products-section {
            padding: 20px;
            text-align: center;
        }

        .products-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .product-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            color: #333;
        }

        .price {
            font-size: 18px;
            color: #444;
        }

        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-container">
        <a href="index.html">
            <img src="logo/1.png" class="logo" alt="Logo">
        </a>
        <div class="nav-links" id="navLinks">
            <a href="#">HOME</a>
            <a href="#">SHOP</a>
            <a href="#">NEW</a>
            <a href="#">ON SALE</a>
        </div>
        <div class="nav-icons">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="white" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="31" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </div>
       
        <div class="hamburger" id="hamburger">
            &#9776;
        </div>
    </div>
</nav>

<section class="header">
    <img src="assets/123002712_2673177159678936_1187946119846381727_n.jpg" alt="Carousel Image">
</section>

<section class="products-section">
    <h2>See What's New</h2>
    <div class="product-grid">
        <div class="product-card">
            <img src="https://via.placeholder.com/400x400" alt="Brigade Clothing">
            <h3>Brigade Clothing</h3>
            <p class="price">$625</p>
        </div>
        <div class="product-card">
            <img src="https://via.placeholder.com/400x400" alt="Brigade Clothing">
            <h3>Brigade Clothing</h3>
            <p class="price">$625</p>
        </div>
        <div class="product-card">
            <img src="https://via.placeholder.com/400x400" alt="Brigade Clothing">
            <h3>Brigade Clothing</h3>
            <p class="price">$625</p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2024 Brigade Clothing. All rights reserved.</p>
</footer>

<script>
   
    document.getElementById('hamburger').addEventListener('click', function () {
        var navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('mobile-active');
    });
</script>

</body>
</html>
