<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="style.css" />
<link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
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
	input[type='submit']:hover {background-color: #80c248;}	
</style>
<script>
function validateName(){
    var name = document.getElementById("username").value;
    name.trim(); 
    if(name.length > 0){ 
        var regexp =/^[A-Za-z\s]+$/;
        if(regexp.test(name)){
            return true;
        }
        else{
            alert(" Your name is not in correct format.Please do not include numbers or special characters in your name. ");
            return false;
        }
    }
    alert("Please fill in your name.");
    return false;
}
function validateEmail(){
    var email = document.getElementById("email").value;
    email.trim();
    if(email.length > 0){ 
        var regexp = /^([\w\.-])+@([\w]+\.){0,3}([A-z]){2,10}$/;
        if(regexp.test(email)){
            return true;
        }
        else{
            alert("Your email is not in correct format.");
            return false;
        }
    }
    alert("Please fill in your email.");
    return false;
}

function confirmPassword() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        alert("Passwords do not match. Please make sure both passwords are the same.");
    }
}

function doubleCheck() {
    var nameIsValid = validateName();
    var emailIsValid = validateEmail();

    if (!nameIsValid) {
        alert("Please enter a valid name with only alphabet characters and spaces.");
        return false;
    }

    if (!emailIsValid) {
        alert("Please enter a valid email address.");
        return false;
    }
	
	var confirm_password = document.getElementById("confirm_password").value;
	var password = document.getElementById("password").value;

    if (password !== confirm_password) {
        alert("Passwords do not match. Please make sure both passwords are the same.");
        return false; 
    }

}

</script>
</head>
<body>
<?php
require('db.php');

// If form submitted, insert values into the database.
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($connection, $username); // Use the database connection
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($connection, $email); // Use the database connection
    $password = stripslashes($password);
    $password = mysqli_real_escape_string($connection, $password); // Use the database connection
    $trn_date = date("Y-m-d H:i:s");

    // Check if the email and username already exists in the database

    $check_query = "SELECT * FROM `users` WHERE email='$email' OR username='$username'";
	$check_result = mysqli_query($connection, $check_query);

	if (mysqli_num_rows($check_result) > 0) {
		echo "<div class='form'><h3>This username or email is already registered. Please use a different username or email.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
	} else {
		// If the username or email is not in the database, proceed to insert the new user
		$query = "INSERT into `users` (username, password, email, trn_date) VALUES ('$username', '" . md5($password) . "', '$email', '$trn_date')";
		$result = mysqli_query($connection, $query);

		if ($result) {
			echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
			// Include the sendEmail.php file
			include('sendEmail.php');
		}
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
		<div class="page-title">Registration</div>
		<div class="logging">
			<div class = "about-us">
				<form name="registration" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return doubleCheck()">
				<p>*Username:<br>
				<input type="text" name="username"  id= "username" placeholder="Username" onchange = "validateName()" class = "inputtext" required></p>
				<p>*Email:<br>
				<input type="email" name="email" id= "email" placeholder="Email" onchange = "validateEmail()" class = "inputtext" required></p>
				<p>*Password:<br>
				<input type="password" name="password" id="password" placeholder="Password" class = "inputtext" required></p>
				<p>*Confirm Password:<br>
				<input type="password" name="confirm_password" id="confirm_password" placeholder="Comfirm Password" onchange = "confirmPassword()" class = "inputtext" required></p>
				<input type="submit" name="submit" value="Register" class = "loginbutton">
				<p style="font-size: 0.8em; color: #808080; font-style: italic; text-align: center;">You will receive a comfirmation e-mail for a successful registration.</p>
				</form>
			</div>
		</div>
</div>
<?php } ?>
</body>
</html>
