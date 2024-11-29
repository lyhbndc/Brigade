<?php
// Webhook file to handle PayMongo events
$payload = file_get_contents("php://input");
$event = json_decode($payload, true);

if (!$event || !isset($event['data']['attributes']['type'])) {
    http_response_code(400);
    die('Invalid webhook payload');
}

$type = $event['data']['attributes']['type'];

if ($type === 'payment.paid') {
    // Payment successful
    $paymentId = $event['data']['id'];
    $amount = $event['data']['attributes']['amount'];
    $email = $event['data']['attributes']['metadata']['email']; // Metadata sent with payment link
    $referenceNumber = $event['data']['attributes']['reference_number'];

    // Update your database: Mark order as paid
    $conn = mysqli_connect("localhost", "root", "", "brigade");
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    $query = "UPDATE `order` SET Status = 'Paid' WHERE ReferenceNumber = '$referenceNumber'";
    mysqli_query($conn, $query);

    // Return success response to PayMongo
    http_response_code(200);
    echo "Payment successful and order updated";
    exit();
} else {
    // Handle other events like payment.failed or payment.expired
    http_response_code(400);
    die('Unhandled webhook event type');
}
?>
