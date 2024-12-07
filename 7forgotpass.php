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

if (isset($_POST['reset'])) {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        // Check if the email exists in the database
        $checkEmailQuery = "SELECT * FROM employees WHERE email = '$email'";
        $emailResult = mysqli_query($conn, $checkEmailQuery);

        if (mysqli_num_rows($emailResult) > 0) {
            // Email exists, generate a random 7-digit password
            $new_password = mt_rand(1000000, 9999999);

            $updatePasswordQuery = "UPDATE employees SET password = '$new_password' WHERE email = '$email'";
            $updateResult = mysqli_query($conn, $updatePasswordQuery);

            if ($updateResult) {
                // Send the new password to the user's email using PHPMailer
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
                    $mail->Subject = 'Your New Password';
                    $mail->Body = "Your new password is: <strong>$new_password</strong>";

                    $mail->send();

                    // Notify the user and redirect to login.php
                    echo "<script>alert('Your new password has been sent to your email.'); window.location.href='7adminlogin.php';</script>";
                    exit();
                } catch (Exception $e) {
                    echo "Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "<script>alert('Error updating password.');</script>";
            }
        } else {
            // Email doesn't exist
            echo "<script>alert('This email address is not registered.');</script>";
        }
    } else {
        echo "<script>alert('Please enter your email address.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Brigade Clothing - Reset Password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Reset Password - Brigade Clothing">
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
            margin: 150px auto;
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
        input[type="email"] {
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
        input[type="email"]:focus {
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
    </style>
</head>

<body>
    <div class="super_container">
        <header class="header trans_300">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="top_nav_left">
                            <div class="marquee"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <div class="top_nav_right"></div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container single_product_container">
            <div class="row">
                <div class="col">
                    <div class="login-container">
                        <h2>Reset Password</h2>
                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Enter Your Registered Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <input type="submit" name="reset" value="Reset Password" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for the navbar behavior or other actions
    </script>
</body>
</html>