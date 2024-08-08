<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $postalCode = $_POST["postal-code"];
    $paymentMethod = $_POST["payment-method"];

    // Create an array of field-value pairs
    $checkoutDetails = array(

        "Contact Number" => $contact,
        "Delivery Address" => $address,
        "Postal Code" => $postalCode,
        "Payment Method" => $paymentMethod
    );

    // Set session variables to pass data to confirmation.php
    session_start();
    $_SESSION["checkout_details"] = $checkoutDetails;

    // Redirect to the confirmation page
    header("Location: confirmation.php");
    exit();
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>
