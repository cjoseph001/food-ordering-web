<!DOCTYPE html>
<html>
    
<head>
      <meta charset="UTF-8">
    
    <title>FOODDASH | About Page</title>
    
    <!--Font-->
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
    
    <!--CSS Files-->
    <link rel="stylesheet" type="text/css" href="style.css">
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
                        <li><a href="about.html">About Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>
<div class = "logging">
<?php
session_start();
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $query = "SELECT * FROM `users` WHERE username='" . $_SESSION['username'] . "'";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
    if (md5($old_password) == $user['password']) {
        if ($new_password === $confirm_new_password) {
            $query = "UPDATE `users` SET password='" . md5($new_password) . "' WHERE username='" . $_SESSION['username'] . "'";
            mysqli_query($connection, $query);
            echo "<p>Password updated successfully. Please log in again.</p>";
            session_destroy();
			$centerLink = "<a href='login.php'>Click here</a>";
              echo "<p>Redirecting back to login page in 5 seconds... $centerLink to return now.</p>";
            header("refresh:5;url=login.php");
            exit();
        } else {
            echo "<p>Password update failed. The new passwords do not match.</p>";
			  $centerLink = "<a href='about.php'>Click here</a>";
              echo "<p>Redirecting back to User Information page in 5 seconds... $centerLink to return now.</p>";
			  header("refresh:5;url=about.php");
        }
    } else {
        echo "<p>Password update failed. The old password is incorrect.</p>";
		$centerLink = "<a href='about.php'>Click here</a>";
        echo "<p>Redirecting back to User Information page in 5 seconds... $centerLink to return now.</p>";
		header("refresh:5;url=about.php");
    }
}
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
