<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "products";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);}

$randomNumber = mt_rand();
$_SESSION['cartID'] = $randomNumber;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_SESSION['checkout_details']) && isset($_SESSION['username'])) {
    $checkoutDetails = $_SESSION['checkout_details'];
    $contactNumber = $checkoutDetails['Contact Number'];
    $paymentMethod = $checkoutDetails['Payment Method'];
    $deliveryAddress = $checkoutDetails['Delivery Address'];
    $username = $_SESSION['username'];
    $cartID = $_SESSION['cartID'];
    $deliveryStatus = "Pending";
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['subtotal'];}

date_default_timezone_set('Asia/Singapore');
$timestamp = time();
$order_time = date("Y-m-d H:i:s", $timestamp);
 
$insertOrderQuery = "INSERT INTO orders (username, cart_id, contact_number, payment_method, delivery_address, payment_amount, delivery_status, order_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtOrder = $mysqli->prepare($insertOrderQuery);
    if ($stmtOrder === false) {
        die("Error: " . $mysqli->error);}

  $stmtOrder->bind_param("sisssdss", $username, $cartID, $contactNumber, $paymentMethod, $deliveryAddress, $totalPrice, $deliveryStatus, $order_time);

    if ($stmtOrder->execute()) {
        $insertOrderItemsQuery = "INSERT INTO order_items (cart_id, product, quantity, subtotal) VALUES (?, ?, ?, ?)";
        $stmtOrderItems = $mysqli->prepare($insertOrderItemsQuery);
        include('sendConfirmation.php');
        if ($stmtOrderItems === false) {
            die("Error: " . $mysqli->error);}
        foreach ($_SESSION['cart'] as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];
            $subtotal = $item['subtotal'];
            $stmtOrderItems->bind_param("isid", $cartID, $product, $quantity, $subtotal);
            $stmtOrderItems->execute();}

        $stmtOrderItems->close();
        $stmtOrder->close();
        $mysqli->close();
        unset($_SESSION['cart']);
        unset($_SESSION['checkout_details']);
        header("Location: order_status.php?order_number=$cartID");
        exit();} else {
    echo "Error: " . $stmtOrder->error;}} else {
    echo "Invalid request or session data missing.";}
?>
