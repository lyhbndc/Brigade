
The code provided creates a user registration form where the entered details, including a generated verification code, are stored in a MySQL database. The verification code is sent via email using PHPMailer. If you want to reset the verification code in the database after the user enters the correct code, you would need an additional step to update the database.

Here’s an example of how you could handle resetting the verification code in your otp_verification.php:

Steps to Reset the Verification Code
Verify the User's Input Code: Check if the entered verification code matches the one in the database.
Reset the Code: Update the database to clear the verification_code field or generate a new code.
Example otp_verification.php
php
Copy code
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['verify'])) {
    $email = $_SESSION['email'];
    $entered_code = $_POST['verification_code'];

    // Fetch the verification code from the database
    $query = "SELECT verification_code FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_code = $row['verification_code'];

        // Compare the entered code with the stored code
        if ($entered_code == $stored_code) {
            // Code matches, reset the verification code
            $update_query = "UPDATE user SET verification_code = NULL WHERE email = '$email'";
            if (mysqli_query($conn, $update_query)) {
                echo "Verification successful. Code has been reset.";
                // Redirect or perform further actions
                header("Location: 4login.php");
                exit();
            } else {
                echo "Error resetting verification code: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid verification code. Please try again.";
        }
    } else {
        echo "No verification code found for this email.";
    }
}
mysqli_close($conn);
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
