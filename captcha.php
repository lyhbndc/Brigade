<?php
session_start();

header('Content-Type: image/png');

// Generate a random 5-character CAPTCHA code
$captcha_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);

// Store the CAPTCHA code in the session
$_SESSION['captcha_code'] = $captcha_code;

// Create a blank image
$image = imagecreatetruecolor(150, 50);

// Set the background color
$background_color = imagecolorallocate($image, 255, 255, 255); // white
imagefill($image, 0, 0, $background_color);

// Add some random noise (dots)
for ($i = 0; $i < 1000; $i++) {
    $dot_color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255)); // light gray
    imagesetpixel($image, rand(0, 150), rand(0, 50), $dot_color);
}

// Add random lines
for ($i = 0; $i < 10; $i++) {
    $line_color = imagecolorallocate($image, rand(150, 200), rand(150, 200), rand(150, 200)); // gray
    imageline($image, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $line_color);
}

// Set the text color
$text_color = imagecolorallocate($image, 0, 0, 0); // black

// Add the CAPTCHA text with basic distortion
$x = 20; // Initial X position
for ($i = 0; $i < strlen($captcha_code); $i++) {
    $font_size = rand(4, 5); // Random font size
    $y = rand(10, 25);       // Random Y position
    imagestring($image, $font_size, $x, $y, $captcha_code[$i], $text_color);
    $x += rand(20, 30);      // Move to the next character position
}

// Output the image
imagepng($image);

// Free up memory
imagedestroy($image);
?>
