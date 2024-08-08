

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FOODDASH | Confirmation Page</title>

    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="product_style.css">
    <link rel="stylesheet" type="text/css" href="checkout.css">
    
    <style>
 .order-status p {
            font-family: 'Gabarito', cursive;
            font-size: 1.85vw;
            color: #654321;
        }

        .order-status {
            width: 70%;
            margin: 0 auto;
            text-align: start;
        }
        
            .loginbutton {
          background-color: #7D522E;
          color: #FFF;
          padding: 10px 20px;
          font-size: 1.75vw;
          font-family: 'Gabarito', cursive;
          border: none;
          cursor: pointer;
          transition: background-color 0.3s;
          border-radius: 10px;
          box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
          display: block;
          margin: 0 auto;
          transition: transform 0.3s;
        }
        .loginbutton:hover{
            background-color: #f57c00;
            transform: scale(1.075);
        }
        
        table {
            font-family: 'Gabarito', cursive;
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin: 0 auto;
            margin-bottom: 1vw;
            border-collapse: separate;
            border-spacing: 3.5px;
        }

        th {
            font-size: 2vw;
            background-color: #A0522D;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 33.33%;
        }

        td {
            font-size: 1.85vw;
            padding: 10px;
            color: #654321;
            background-color: #F0D9B5;
            text-align: center;
            width: 33.33%;
        }

        h2 {
            text-align: center;
            font-size: 2.25vw;
            font-family: 'Gabarito', cursive;
            margin: 2.5vw;
            color: #654321;
        }
        .label-cell {
        background-color: #A0522D;
        color: white;
    }
        .progress-box {
             width: 100%;
            font-family: 'Gabarito', cursive;
            font-size: 1.85vw;
              margin-top: 3.5vw;
}
        .progressbar{
            counter-reset: step;
            margin-right: 5vw;
            padding-bottom: 8.5vw;
        }
        .progressbar li{
        list-style-type: none;
        float: left;
        width: 25%;
        position: relative;
        text-align: center;
        }
        .progressbar li:before{
            content: counter(step);
            counter-increment: step;
            width: 3vw;
            height: 3vw;
            line-height: 3vw;
            border: 1px solid;
            display: block;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }
         .progressbar li:after{
            content: '';
            position: absolute;
             width: 100%;
                 height: 0.5vw;
             background-color: #ddd;
             top: 1.5vw;
             left: -50%;
             z-index:-1;
        }
        .progressbar li:first-child:after{
            content: none;
        }
         .progressbar li.active{
            color: brown;
        }
         .progressbar li.active:before{
            border-color: brown;
              background-color: brown;
             color: #fff;
        }
         .progressbar li.active + li:after{
            background-color: brown;
        }
    </style>
</head>
<body>
    <div class="content">
        <header>
            <div class="header-content">
                <h1 class="header-title">FoodDash</h1>
                <nav>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="mycart.php">My Cart</a></li>
                        <li><a href="checklogin.php">My Account</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="page-title">ORDER STATUS</div>

        <div class="progress-box">
            <ul class="progressbar">
                <li class="active">My Cart</li>
                <li class="active">Check Out</li>
                <li class="active">Confirmation</li>
                <li class="active">Order Status</li>
            </ul>
        </div>

        <div class="order-status">
            <p>We received your order.</p>

            <?php
            session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "products";
            $db = new mysqli($servername, $username, $password, $database);

            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);}
            $cartNumber = $_GET['order_number'];?>
            
            <?php
            if (isset($cartNumber)) {
                $query = "SELECT username, delivery_address, payment_method, payment_amount, delivery_status, order_time FROM orders WHERE cart_id = ?";
                $stmt = $db->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("i", $cartNumber);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<h2>Order Details</h2>';
                        $row = $result->fetch_assoc();

                        $formattedDate = date('Y-m-d', strtotime($row['order_time']));
                        $formattedTime = date('H:i:s', strtotime($row['order_time']));

                        echo '<table>';
                        echo '<tr><td class="label-cell">Order Date</td><td>' . $formattedDate . '</td></tr>';
                        echo '<tr><td class="label-cell">Order Time</td><td>' . $formattedTime . '</td></tr>';
                        echo '<tr><td class="label-cell">Order ID</td><td>' . $cartNumber . '</td></tr>';
                        echo '<tr><td class="label-cell">Customer Name</td><td>' . $row['username'] . '</td></tr>';
                        echo '<tr><td class="label-cell">Delivery Address</td><td>' . $row['delivery_address'] . '</td></tr>';
                        echo '<tr><td class="label-cell">Payment Method</td><td>' . $row['payment_method'] . '</td></tr>';
                        echo '<tr><td class="label-cell">Payment Amount</td><td>S$' . $row['payment_amount'] . '</td></tr>';
                        echo '<tr><td class="label-cell">Delivery Status</td><td>' . $row['delivery_status'] . '</td></tr>';
                        echo '</table>';
                    } else {
                        echo 'No data found for order number: ' . $cartNumber;
                    }

                    $stmt->close();
                }
            }

            if (isset($cartNumber)) {
                $query = "SELECT product, quantity, subtotal FROM order_items WHERE cart_id = ?";
                $stmt = $db->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("i", $cartNumber);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $totalQuantity = 0;
                        $totalPrice = 0;
                        echo '<h2>Order Items</h2>';
                        echo '<table>';
                        echo '<tr><th>Product</th><th>Quantity</th><th>Subtotal</th></tr>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['product'] . '</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td> S$' . $row['subtotal'] . '</td>';
                            echo '</tr>';
                            $totalQuantity += $row['quantity'];
                            $totalPrice += $row['subtotal'];
                        }

                        echo '<tr>';
                        echo '<th> Total </th>';
                        echo '<th>' . $totalQuantity . '</th>';
                        echo '<th> S$' . $totalPrice . '</th>';
                        echo '</tr>';
                        echo '</table>';
                    } else {
                        echo 'No order items found for order number: ' . $cartNumber;
                    } $stmt->close();}}
            
            echo '<br>';
            echo '<button type="button" class="loginbutton" onclick="location.href=\'about.php\';">Check Your Order at My Account</button>';
            ?>
        </div>
        <footer>
            <p><a>Contact Us Here!</a></p>
            <ul class="social-icons">
                <li><a href="https://www.instagram.com/chris281502" target="_blank"><img src="images/instas.png" alt="Instagram"></a></li>
                <li><a href="https://twitter.com/your-twitter-profile" target="_blank"><img src="images/twitts.png" alt="Twitter"></a></li>
                <li><a href="cjoseph001@e.ntu.edu.sg"><img src="images/mails.png" alt="Email"></a></li>
            </ul>
            <p>Copyright&copy; FOODDASH 2023</p>
        </footer>
    </div>
</body>
</html>
