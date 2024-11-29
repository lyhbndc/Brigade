<?php
if (!isset($_GET['client_key']) || !isset($_GET['payment_intent_id'])) {
    die('Invalid request. Missing client key or payment intent ID.');
}

$clientKey = htmlspecialchars($_GET['client_key']);
$paymentIntentId = htmlspecialchars($_GET['payment_intent_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Complete Payment</title>
    <script src="https://cdn.paymongo.com/v1"></script>
</head>
<body>
    <h1>Complete Your Payment</h1>
    <button id="payButton">Pay Now</button>

    <script>
        const clientKey = "<?php echo $clientKey; ?>";
        const paymongo = Paymongo(clientKey);

        document.getElementById("payButton").addEventListener("click", () => {
            paymongo.checkout({
                paymentMethods: ["card", "gcash"], // Allowed methods
                redirect: true, // Redirect after payment
            });
        });
    </script>
</body>
</html>
