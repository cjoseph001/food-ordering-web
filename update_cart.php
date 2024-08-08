
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product = isset($_POST["product"]) ? $_POST["product"] : '';
    $updatedQuantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 0;
    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as &$item) {
            if ($item["product"] === $product) {
                $item["quantity"] = $updatedQuantity;
                $item["subtotal"] = $item["price"] * $updatedQuantity;
            }
        }
    }
}
header("Location: mycart.php");
exit();
?>
