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
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .verification-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
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
