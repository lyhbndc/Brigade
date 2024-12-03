<?php
session_start();

header('Content-Type: image/png');

// Generate a random 5-character CAPTCHA code
$captcha_code = substr(md5(rand()), 0, 5);

// Store the CAPTCHA code in the session
$_SESSION['captcha_code'] = $captcha_code;

// Create a blank image
$image = imagecreatetruecolor(120, 40);

// Generate a random background color
$background_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

// Fill the image with the background color
imagefill($image, 0, 0, $background_color);

// Set the text color (black)
$text_color = imagecolorallocate($image, 0, 0, 0);

// Add the CAPTCHA code to the image
imagestring($image, 5, 35, 10, $captcha_code, $text_color);

// Output the image as PNG
imagepng($image);

// Free up memory
imagedestroy($image);
?>
