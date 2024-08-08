<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];
    $quantity = intval($_POST['quantity']);
    $price = $_POST['cost'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];}
    
    $found = false;
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['product'] == $product) {
            $_SESSION['cart'][$index]['quantity'] += $quantity;
            $_SESSION['cart'][$index]['subtotal'] += $quantity * $price;
            $found = true;
            break;}
	}
    
    if (!$found) {
        $subtotal = $quantity * $price;
        $item = [
            'product' => $product,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,];
        $_SESSION['cart'][] = $item;}
    header("Location: order_added.html");
    exit();
}
?>
