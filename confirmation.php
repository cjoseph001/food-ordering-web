<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
      <meta charset="UTF-8">
    
    <title>FOODDASH | Confirmation Page</title>
    
    <!--Font-->
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
    
    <!--CSS Files-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="product_style.css">
    <link rel="stylesheet" type="text/css" href="checkout.css">
    <style> .progress-box {
    width: 100%;
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
        <div class="page-title">CONFIRMATION PAGE</div>
        

        <div class="mycart" style="text-align: center; font-family: 'Gabarito', cursive; font-size: 1.75vw; margin-bottom: 2.5vw; margin-top: 3.5vw;">
               <div class="progress-box">
    <ul class="progressbar">
        <li  class="active">My Cart</li>
        <li class="active">Check Out</li>
        <li class="active">Confirmation</li>
        <li>Order Status</li>
 
    </ul>
</div>
            <?php
                if (isset($_SESSION["checkout_details"])) {
                $checkoutDetails = $_SESSION["checkout_details"];

                echo '<table class="table-head">';
                echo '<tr>';
                echo '<td>User Information</td>';
                echo '</tr>';
                echo '</table>';

                if (isset($_SESSION['username'])) {
                echo '<table class="total-row">';
                echo '<tbody>';
                echo '<tr>';
                echo '<td>Username</td>';
                echo '<td>' . $_SESSION['username'] . '</td>';
                echo '</tr>';

                $account_username = $_SESSION['username'];
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "products";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT email FROM users WHERE username = '$account_username'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $email = $row['email'];

                    echo '<tr>';
                    echo '<td>Email</td>';
                    echo '<td>' . $email . '</td>';
                    echo '</tr>';
                } else {
                    echo '<tr>';
                    echo '<td>Email</td>';
                    echo '<td>Email not found</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                }
                          
                          
                echo '<table class="table-head">';
                echo '<tr>';
                echo '<td>Delivery Details</td>';
                echo '</tr>';
                echo '</table>';

                echo '<table class="total-row">';
                echo '<tbody>';
                
                foreach ($checkoutDetails as $field => $value) {
                    if ($field !== 'Payment Method') {
                        echo '<tr>';
                        echo '<td>' . $field . '</td>';
                        echo '<td>' . $value . '</td>';
                        echo '</tr>'; }}
                echo '</tbody>';
                echo '</table>';
                } else {
                echo "Checkout details not found.";}

            echo '<table class="table-head">';
            echo '<tr>';
            echo '<td>Payment Details</td>';
            echo '</tr>';
            echo '</table>';
            
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $totalQuantity = 0;
                $totalPrice = 0;

                foreach ($_SESSION['cart'] as $item) {
                    $subtotal = $item['quantity'] * $item['price'];
                    $totalQuantity += $item['quantity'];
                    $totalPrice += $subtotal;
                }
                
                if (isset($checkoutDetails["Payment Method"])) {
                    $paymentMethod = $checkoutDetails["Payment Method"];
                    echo '<table class="total-row">';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>Total Payment Amount</td>';
                    echo '<td>S$' . number_format($totalPrice, 2) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Payment Method</td>';
                    echo '<td>' . $paymentMethod . '</td>';
                    echo '</tr>';
                    echo '</tbody></table>';
                }
            }

            echo '<form action="insert_order.php" method="post">';
            echo '<div class="button-container2">';
            echo '<button type="submit" class="add-food-button">Place Order</button>';
            echo '<p style="font-size: 0.8em; color: #808080; font-style: italic; text-align: center;">You will receive a comfirmation e-mail after placing the order.</p>';
            echo '</div>';
            echo '</form>';
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
