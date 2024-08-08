<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>FOODDASH | Admin Page</title>
    <!-- Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap"
        rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style type="text/css">
table {
    border-collapse: collapse;
}

th,
td {
    border: 1px solid black;
    padding: 10px;
    text-align: center;
    width: 14%;
}

select {
    width: 7vw;
    padding: 0.5vw;
    font-size: 1vw;
}

input[type="submit"] {
    width: 7vw;
    height: 2.5vw;
    padding: 0.5vw;
    font-size: 1.2vw;
}
</style>

<body>
    <div class="content">
        <header>
            <div class="header-content">
                <h1 class="header-title">FoodDash</h1>
                <nav>
                    <ul>
                        <li><a href="order_data.php">Active Orders</a></li>
                        <li><a href="past_data.php">Past Orders</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="page-title">ACTIVE ORDERS</div>
        <div class="mycart"
            style="text-align: center; font-family: 'Gabarito', cursive; font-size: 1.5vw; margin-bottom: 2.5vw; margin-top: 3.5vw;">
            <table border="1">
                <tr>
                    <th>Order ID</th>
                    <th>Cart ID</th>
                    <th>Username</th>
                    <th>Order Created</th>
                    <th>Delivery Address</th>
                    <th>Payment Amount</th>
                    <th>Delivery Status</th>
                </tr>

                <?php
                $db = new mysqli('localhost', 'root', '', 'products');
                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cartId = $_POST['cart_id'];
                    $newDeliveryStatus = $_POST['new_delivery_status'];
                    $updateQuery = "UPDATE orders SET delivery_status = '$newDeliveryStatus' WHERE cart_id = $cartId";
                    $db->query($updateQuery);
                }
                $query = "SELECT order_id, cart_id, username, order_time, delivery_address, payment_amount, delivery_status FROM orders WHERE delivery_status = 'In Transit' OR delivery_status = 'Pending'";
                $result = $db->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['cart_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . date('Y-m-d H:i:s', strtotime($row['order_time'])) . "</td>";
                    echo "<td>" . $row['delivery_address'] . "</td>";
                    echo "<td>" . $row['payment_amount'] . "</td>";
                    echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='cart_id' value='" . $row['cart_id'] . "'>
                            <select name='new_delivery_status'>
                                <option value='Delivered' " . ($row['delivery_status'] == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                                <option value='In Transit' " . ($row['delivery_status'] == 'In Transit' ? 'selected' : '') . ">In Transit</option>
                                <option value='Pending' " . ($row['delivery_status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            </select>
                            <input type='submit' value='Update'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
        <footer>
            <p><a>Contact Us Here!</a></p>
            <ul class="social-icons">
                <li><a href="https://www.instagram.com/chris281502" target="_blank"><img src="images/instas.png"
                            alt="Instagram"></a></li>
                <li><a href="https://twitter.com/your-twitter-profile" target="_blank"><img src="images/twitts.png"
                            alt="Twitter"></a></li>
                <li><a href="cjoseph001@e.ntu.edu.sg"><img src="images/mails.png" alt="Email"></a></li>
            </ul>
            <p>Copyright&copy; FOODDASH 2023</p>
        </footer>
    </div>
</body>

</html>