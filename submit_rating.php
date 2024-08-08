<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FOODDASH | Confirmation Page</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="product_style.css">
    <link rel="stylesheet" type="text/css" href="checkout.css">
	<style>
	.logging p {
		font-family: 'Gabarito', cursive;
		font-size: 1.6vw;
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
        <div class="page-title">Rate Your Order</div>
      <div class="logging">     
<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cart_id = $_POST['cart_id'];
        $rating = $_POST["rating"];
        $comment = $_POST["comment"];

        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "products";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO order_rating (cart_id, star, comment) VALUES ('$cart_id', '$rating', '$comment')";

		if ($conn->query($sql) === TRUE) {
		  echo "<p>Your feedback is invaluable to us and plays a pivotal role in our continuous pursuit of excellence.</p>";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	}
?>
</div>
<div class="button-container2">
    <button type="button" class="add-food-button" onclick="location.href='about.php';">Go Back</button>
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

