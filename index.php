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

        header {
            background-color: #222;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            color: white;
            font-size: 24px;
        }

        nav {
            background-color: #111;
            padding: 10px;
        }

        .nav-container {
            display: flex;
            flex-wrap: wrap; /* Allows items to wrap on smaller screens */
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            width: 150px; /* Adjust logo width as needed */
            height: auto;
        }

        .nav-links {
            flex-grow: 1;
            display: flex;
            justify-content: center; /* Centers the links horizontally */
            flex-wrap: wrap; /* Allows links to wrap on smaller screens */
        }

        .nav-icons {
            display: flex;
            gap: 10px;
        }

        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }

        nav a:hover {
            background-color: #575757;
        }

        svg {
            padding: 14px 10px;
            cursor: pointer;
        }

        .header {
            margin: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            width: 100%;
            height: auto;
            object-fit: cover;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            nav .logo {
                width: 120px; /* Adjust logo size for mobile */
            }

            nav a {
                font-size: 16px; /* Smaller font size for mobile */
            }

            .products-section h2 {
                font-size: 20px; /* Smaller title font size for mobile */
            }

            .product-card h3 {
                font-size: 16px; /* Smaller product title for mobile */
            }

            .product-card p {
                font-size: 14px; /* Smaller price font size for mobile */
            }
        }

        @media (max-width: 480px) {
            nav {
                padding: 5px; /* Less padding on mobile */
            }

            nav a {
                padding: 10px 15px; /* Smaller padding on mobile */
            }
        }
    </style>
</head>
<body>
<nav>
    <div class="nav-container">
        <a href="index.html">
            <img src="logo/1.png" class="logo" alt="Logo">
        </a>
        <div class="nav-links">
            <a href="#">HOME</a>
            <a href="#">SHOP</a>
            <a href="#">NEW</a>
            <a href="#">ON SALE</a>
        </div>
        <div class="nav-icons">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </div>
    </div>
</nav>

<section class="header">
    <img src="https://via.placeholder.com/1200x500" alt="Carousel Image">
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

</body>
</html>