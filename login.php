<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
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
	}
    
    a.registration-link {
    font-size: 1.75vw;
    color: #7D522E;
    text-decoration: underline;
}
    a.registration-link:hover {
    color: brown;
    text-decoration: underline;
}
    .login-title {
    font-family: 'Gabarito', cursive;
    font-size: 2vw;
    margin-bottom: 2.5vw;
}
    input[type='submit']{
        transition: 0.3s;
    }
	input[type='submit']:hover {background-color: #f57c00;
    transform: scale(1.1)}    	
</style>
</head>
	
<body>
	
	<?php
	$connection = mysqli_connect('localhost', 'root', '', 'products');
	if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
	}
	$select_db = mysqli_select_db($connection, 'products');
	if (!$select_db) {
    die("Database Selection Failed: " . mysqli_error($connection));
	}
	session_start();
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$username = stripslashes($username);
		$username = mysqli_real_escape_string($connection, $username);
		$password = stripslashes($password);
		$password = mysqli_real_escape_string($connection, $password);
		
		$query = "SELECT * FROM `users` WHERE username='$username' and password='" . md5($password) . "'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

		$rows = mysqli_num_rows($result);
		if ($rows == 1) {
			$_SESSION['username'] = $username;
			header("Location: about.php"); 
		} else {
			echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
		}
	} else {
	?>
	
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
		
		<div class = "logging">
			<div class="page-title">LOGIN PAGE</div>
			<div class = "about-us">
                 <div class="login-title">Enter your username and password:</div>
			<form action="" method="post" name="login">
				<p>*Username:<br>
				<input type="text" name="username" placeholder="Username" class = "inputtext" required></p>
				<p>*Password:<br>
				<input type="password" name="password" placeholder="Password" class = "inputtext" required></p>
				<br><input name="submit" type="submit" value="Login" class = "loginbutton">
			</form>
			<p>Not registered yet? <a class="registration-link" href='registration.php'>Register Here</a></p>
			</div>
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
<?php } ?>
</body>
</html>
