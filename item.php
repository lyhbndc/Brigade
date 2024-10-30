<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header img {
            width: 150px;
        }
        .nav {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px 0;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
        }
        .container {
            display: flex;
            padding: 20px;
        }
        .product-gallery {
            width: 30%;
            text-align: center;
        }
        .product-gallery img {
            width: 80%;
            margin-bottom: 10px;
        }
        .product-info {
            width: 70%;
            padding-left: 40px;
        }
        .product-info h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .product-info h2 {
            font-size: 18px;
            color: gray;
            margin: 5px 0 20px 0;
        }
        .product-price {
            font-size: 24px;
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .size-options, .color-options {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .size-options button {
            margin: 0 5px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #333;
            cursor: pointer;
        }
        .add-to-cart {
            padding: 15px 30px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .description {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="logo.png" alt="Brigade Logo">
    </div>
    
    <div class="nav">
        <a href="#">HOME</a>
        <a href="#">SHOP</a>
        <a href="#">NEW</a>
        <a href="#">ON SALE</a>
    </div>
    
    <div class="container">
        <div class="product-gallery">
            <img src="front.jpg" alt="Front View">
            <img src="back.jpg" alt="Back View">
        </div>
        
        <div class="product-info">
            <h1>Brigade Clothing</h1>
            <h2>Casual Plain Button Front Jacket</h2>
            <p class="product-price">$700</p>
            
            <div class="size-options">
                <label for="size">Select Size:</label>
                <button>S</button>
                <button>M</button>
                <button>L</button>
                <button>XL</button>
                <button>2XL</button>
                <button>3XL</button>
            </div>

            <button class="add-to-cart">Add to Bag</button>
            
            <div class="description">
                <p>Crafted from a comfortable blend of 80% cotton and 20% polyester, it features classic screen-printed designs that embody both style and substance. Plus, enjoy a free sticker with your purchase for an added touch of flair.</p>
                <p><strong>Colour Shown:</strong> Black</p>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
