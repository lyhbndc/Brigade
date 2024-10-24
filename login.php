<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
            justify-content: space-between; 
            align-items: center; 
        }

        nav .logo {
            width: 150px; 
            height: auto;
            margin-top: 10px;
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

        nav a:hover {
            background-color: transparent;
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

        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh; 
        }

        .login-form {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
            margin-top: 10px;
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
            width: 94%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        .login-btn:hover {
            background-color: gray;
        }
        h2{
            font-size: 40px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }
    </style>
</head>
<body>
<nav>
<a href="index.php">
    <img src="logo/1.png" class="logo" > 
</a>      
</nav>

<section class="login-container">
    <div class="login-form">
        <h2>LOGIN</h2>
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

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        alert(`Logging in with Username: ${username} and Password: ${password}`);
    });
</script>

</body>
</html>
