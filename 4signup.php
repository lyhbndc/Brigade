<?php
session_start();

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['next'])) {
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['password'], $_POST['city'], $_POST['zip_code'], $_POST['contact_no'], $_POST['email'], $_POST['username']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['zip_code']) && !empty($_POST['contact_no']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {

        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zip = $_POST['zip_code'];
        $contact = $_POST['contact_no'];
        $email = $_POST['email'];
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Generate a random 6-digit verification code
        $verification_code = mt_rand(100000, 999999);

        // Insert data into the user table
        $query = "INSERT INTO user (firstname, lastname, address, city, zip, contact, email, username, password, verification_code) VALUES ('$firstname', '$lastname', '$address', '$city', '$zip', '$contact', '$email', '$user', '$pass', '$verification_code')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Send the verification email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.mailersend.net'; // Update this with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'MS_QkjTfQ@trial-pq3enl6w3n042vwr.mlsender.net'; // SMTP username
                $mail->Password = 'fAtQJCLJh8TX4VSX'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('MS_QkjTfQ@trial-pq3enl6w3n042vwr.mlsender.net', 'Brigade');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body = "Your verification code is: <strong>$verification_code</strong>";

                $mail->send();

                // Store email in session for verification
                $_SESSION['email'] = $email;
                header("Location: otp_verification.php"); // Redirect to OTP verification page
                exit();
            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Please fill in all fields.";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Brigade Clothing</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="About Brigade Clothing">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/single_responsive.css">
    <style>
        body {
            background-color: white;
            color: black;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 600px;
            margin: 150px auto; /* Center the form */
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: black;
            font-weight: bold;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 14px;
        }
        input[type="text"],input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #444;
            border-radius: 20px;
            background-color: white;
            color: gray;
            font-size: 14px;
            transition: border 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1px solid gray;
            outline: none;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            margin-top: 10px;
            padding: 12px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            width: 280px;
            transition: background-color 0.3s, transform 0.2s;
        }
        input[type="submit"]:hover {
            background-color: #555;
            transform: translateY(-1px);
        }
        .forgot-password {
            margin-top: 10px;
            font-size: 12px;
        }
        .forgot-password a {
            color: #bbb;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 13px;
            color: gray;
            font-size: 20px;
        }
        .footer-logo{
           cursor: default; 
        }
        .form-control{
            width: 100%;
            padding: 7px;
            margin: 15px 0;
            border: 1px solid #444;
            border-radius: 20px;
            background-color: white;
            color: gray;
            font-size: 14px;
            transition: border 0.3s;
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
                                <a href="1index2.php"><img src="assets/1.png"></a>
                            </div>
                            <nav class="navbar">
                                
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
                    <!-- Login Form -->
                    <div class="login-container">
                        <img src="assets/2.png" class="footer-logo">
                        <br><br>
                        <form method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first-name">First Name:</label>
                                    <input type="text" id="first-name" name="first_name" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last-name">Last Name:</label>
                                    <input type="text" id="last-name" name="last_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="city">City:</label>
                <select id="city" name="city" class="form-control" required>
                    <option value="" disabled selected>Select your city</option>
                    <option value="New York">New York</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Houston">Houston</option>
                    <option value="Miami">Miami</option>
                    <option value="San Francisco">San Francisco</option>
                    <option value="Seattle">Seattle</option>
                </select>
            </div>
                                <div class="form-group col-md-6">
                                    <label for="zip">Zip Code:</label>
                                    <input type="text" id="zip" name="zip_code" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact">Contact No:</label>
                                <input type="text" id="contact" name="contact_no" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                          <div class="form-group">
    <label for="password">Password:</label>
    <div style="position: relative;">
        <input type="password" id="signup-password" name="password" class="form-control" required oninput="checkPasswordStrength()">
        <span id="password-strength" class="password-strength"></span>
        <i id="toggle-password-icon" class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('signup-password', 'toggle-password-icon')"></i>
    </div>
</div>

<div class="form-group">
    <label for="confirm-password">Confirm Password:</label>
    <div style="position: relative;">
        <input type="password" id="confirm-password" class="form-control" required oninput="checkPasswordMatch()">
        <span id="match-status" class="match-status"></span>
        <i id="toggle-confirm-password-icon" class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('confirm-password', 'toggle-confirm-password-icon')"></i>
    </div>
    <input type="submit" name ="next" value="Sign Up" class="btn btn-primary">
</div>

                                
                                
                                
                            </div>
                            
                            </div>
                          
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->

        <footer style="background-color: black; color: white;" class="bg3 p-t-75 p-b-32">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3 p-b-50">
                        <br>
                        <h4 class="stext-301 cl0 p-b-30">
                            <img src="assets/Untitled design.png" class="footer-logo">
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
    </div>
    <script>
        function togglePasswordVisibility(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(iconId);
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
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
        function checkPasswordStrength() {
            const password = document.getElementById('signup-password').value;
            const strengthIndicator = document.getElementById('password-strength');
            let strength = 'Weak';
            let color = 'red';

            if (password.length >= 8) {
                if (/[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength = 'Strong';
                    color = 'green';
                } else if ((/[A-Za-z]/.test(password) && /\d/.test(password)) || (/[A-Za-z]/.test(password) && /[^A-Za-z0-9]/.test(password))) {
                    strength = 'Medium';
                    color = 'orange';
                }
            }

            strengthIndicator.textContent = `Password is ${strength}`;
            strengthIndicator.style.color = color;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('signup-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const matchStatus = document.getElementById('match-status');

            if (password === confirmPassword) {
                matchStatus.textContent = 'Passwords match';
                matchStatus.style.color = 'green';
            } else {
                matchStatus.textContent = 'Passwords do not match';
                matchStatus.style.color = 'red';
            }
        }
    </script>
    
</body>
</html>
