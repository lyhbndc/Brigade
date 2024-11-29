<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['verify'])) {
    $email = $_SESSION['email'];
    $input_code = $_POST['verification_code'];

    $query = "SELECT verification_code FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && $row['verification_code'] == $input_code) {
        // Update user verification status
        $update_query = "UPDATE user SET verification_code = NULL WHERE email = '$email'";
        mysqli_query($conn, $update_query);

        echo "Verification successful!";
        // Redirect to login or another page
        header("Location: 4login.php");
        exit();
    } else {
        echo "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .verification-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 400px;
            margin: 170px auto; 
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: black;
            font-weight: bold;
            font-family: poppins;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <h2>OTP Verification</h2>
        <p>We've sent a verification code to your email. Please enter it below:</p>
        <form method="POST">
            <input type="text" name="verification_code" placeholder="Enter verification code" required>
            <input type="submit" name="verify" value="Verify">
        </form>
    </div>
</body>
</html>
