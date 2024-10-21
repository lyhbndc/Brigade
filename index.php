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
            display: flex;
            justify-content: center;
            background-color: #111;
            padding: 10px;
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

        .header {
            margin: 20px;
            display: flex;
            justify-content: space-between;
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
    </style>
</head>
<body>
<nav>
    <img src="">
    <a href="#">HOME</a>
    <a href="#">SHOP</a>
    <a href="#">NEW</a>
    <a href="#">ON SALE</a>
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

</section>

<footer>
    <p>&copy; 2024 Brigade Clothing. All rights reserved.</p>
</footer>

</body>
</html>
