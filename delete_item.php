<?php
session_start();

if (isset($_POST['product'])) {
    $remove_product = $_POST['product'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product'] === $remove_product) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}
header("Location: mycart.php");
exit();
?>
