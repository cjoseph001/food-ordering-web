<?php
session_start();
require('db.php');

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">

	<title>FOODDASH | About Page</title>

	<!--Font-->
	<link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">

	<!--CSS Files-->
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="product_style.css">

	<style>
		.inputtext {
			font-family: 'Gabarito', cursive;
			font-size: 1.6vw;
			width: 95%;
			height: 2.5vw;
			padding: 1vw;
			margin: 0.5vw 0;
		}

		.logging p {
			font-family: 'Gabarito', cursive;
			font-size: 1.6vw;
		}

		.logging li {
			font-family: 'Gabarito', cursive;
			font-size: 1.6vw;
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

		.loginbutton:hover {
			transform: scale(1.075);
			background-color: #f57c00
		}

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

		table {
			font-family: 'Gabarito', cursive;
			width: 90%;
			table-layout: fixed;
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
			width: 20%;
		}

		td {
			font-size: 1.85vw;
			padding: 20px;
			color: #654321;
			background-color: #F0D9B5;
			text-align: center;
			width: 20%;
		}

		h2 {
			text-align: center;
			font-size: 2.25vw;
			font-family: 'Gabarito', cursive;
			margin-top: 1vw;
			margin-bottom: 3vw;
			color: #654321;
		}

		.label-cell {
			background-color: #A0522D;
			color: white;
		}
	</style>
	<script>
		function togglePasswordForm() {
			var passwordForm = document.getElementById("password-form");
			var button = document.getElementById("passwordToggleButton");

			if (passwordForm.style.display === "none" || passwordForm.style.display === "") {
				passwordForm.style.display = "block";
				button.innerHTML = "Hide Form";
			} else {
				passwordForm.style.display = "none";
				button.innerHTML = "Change Your Password";
			}
		}
	</script>
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
		<div class="page-title">MY ACCOUNT</div>
		<div class="logging">
			<div class="about-us">
				<form action="mycart.php" method="post" style="margin-bottom:2vw;">
					<input type="submit" class="loginbutton" value="Start Order">
				</form>
				<h2>Welcome to User Center, <?php echo $_SESSION['username']; ?> ! </h2>
				<p>Your personal hub for managing your orders. Here, you can:</p>
				<ul>
					<li>Effortlessly track your pending orders</li>
					<li>Provide valuable feedback on completed orders</li>
					<li>Conveniently update your password</li>
				</ul>
				<p>We're committed to delivering a seamless user experience, making your shopping journey more efficient
					and enjoyable. Thank you for choosing our services, and we look forward to your feedback and
					suggestions.</p>

				<form action="logout.php" method="post">
					<input type="submit" class="loginbutton" value="Log-out">
				</form>
				<br>
				<button id="passwordToggleButton" onclick="togglePasswordForm()" class="loginbutton">Change Your
					Password</button>
			</div>
		</div>

		<div id="password-form" style="display: none;">
			<br>
			<h2>Change your password here</h2>
			<div class="logging">
				<form method="post" action="update_password.php">
					<div class="about-us">
						<p>Old Password:<br>
							<input type="password" name="old_password" id="old_password" class="inputtext" required>
						</p>
						<p>New Password:<br>
							<input type="password" name="new_password" id="new_password" class="inputtext" required>
						</p>
						<p>Confirm New Password:<br>
							<input type="password" name="confirm_new_password" id="confirm_new_password" class="inputtext" required>
						</p><br>
						<input type="submit" class="loginbutton" value="Change Password">
					</div>
				</form>
				<br>
			</div>
		</div>

		<br>
		<h2>Rate your past order</h2>
		<div class="mycart" style="text-align: center; font-family: 'Gabarito', cursive; font-size: 1.5vw; margin-bottom: 2.5vw; margin-top: 3.5vw;">
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

			$username = $_SESSION['username'];
			$query = "SELECT order_id, cart_id, username, contact_number, delivery_address, payment_amount, delivery_status, order_time 
				  FROM orders 
				  WHERE username = '$username' 
				  AND delivery_status = 'Delivered' 
				  AND cart_id NOT IN (SELECT cart_id FROM order_rating)";
			$result = $db->query($query);

			if ($result->num_rows > 0) {
				echo "<table border=\"0\">";
				echo "<tr>";
				echo "<th>Cart ID</th>";
				echo "<th>Username</th>";
				echo "<th>Order Created</th>";
				echo "<th>Delivery Address</th>";
				echo "<th>Payment Amount</th>";
				echo "</tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row['cart_id'] . "</td>";
					echo "<td>" . $row['username'] . "</td>";
					echo "<td>" . date('Y-m-d H:i:s', strtotime($row['order_time'])) . "</td>";
					echo "<td>" . $row['delivery_address'] . "</td>";
					echo "<td>" . $row['payment_amount'] . "</td>";
					if ($row['delivery_status'] === 'Delivered') {
						echo '<td style="border: none;">';
						echo '<form action="rate_order.php" method="post">';
						echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
						echo '<button type="submit" class="loginbutton">Feedback</button>';
						echo '</form>';
						echo '</div></td>';
					}
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<h1 style='font-family: Gabarito, cursive;'>No order to comment</h1>";
			}
			?>
		</div>
		<br>
		<h2>Your order on the way...</h2>
		<div class="mycart" style="text-align: center; font-family: 'Gabarito', cursive; font-size: 1.5vw; margin-bottom: 2.5vw; margin-top: 3.5vw;">
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


			$username = $_SESSION['username'];
			$query = "SELECT order_id, cart_id, username, contact_number, delivery_address, payment_amount, delivery_status, order_time FROM orders WHERE username = '$username' AND (delivery_status = 'In Transit' OR delivery_status = 'Pending')";
			$result = $db->query($query);
			if ($result->num_rows > 0) {
				echo "<table border=\"0\">";
				echo "<tr>";
				echo "<th>Cart ID</th>";
				echo "<th>Username</th>";
				echo "<th>Order Created</th>";
				echo "<th>Delivery Address</th>";
				echo "<th>Payment Amount</th>";
				echo "</tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row['cart_id'] . "</td>";
					echo "<td>" . $row['username'] . "</td>";
					echo "<td>" . date('Y-m-d H:i:s', strtotime($row['order_time'])) . "</td>";
					echo "<td>" . $row['delivery_address'] . "</td>";
					echo "<td>" . $row['payment_amount'] . "</td>";
					echo '<td style="border: none;">';
					echo '<form action="order_status.php?order_number=' . $row['cart_id'] . '" method="post">';
					echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
					echo '<button type="submit" class="loginbutton">View Details</button>';
					echo '</form>';
					echo '</div></td>';
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<h1 style='font-family: Gabarito, cursive;'>No order on the way</h1>";
			}

			?>
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
	</div>
</body>

</html>