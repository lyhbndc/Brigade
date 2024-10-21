<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing - Login</title>
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

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh; /* Center the form vertically */
        }

        .login-form {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        .login-btn:hover {
            background-color: #45a049;
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
    <a href="#">HOME</a>
    <a href="#">SHOP</a>
    <a href="#">NEW</a>
    <a href="#">ON SALE</a>
</nav>

<header>
    <h1>Brigade Clothing - Login</h1>
</header>

<section class="login-container">
    <div class="login-form">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</section>

<footer>
    <p>&copy; 2024 Brigade Clothing. All rights reserved.</p>
</footer>

<script>
    // Simple login form submission handling
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Here you can add your logic for authentication
        alert(`Logging in with Username: ${username} and Password: ${password}`);
    });
</script>

</body>
</html>
