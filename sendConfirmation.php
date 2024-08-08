<?php
//for mail sending using mac
/*require "/Applications/XAMPP/xamppfiles/htdocs/mail_patch.php";
use function mail_patch\mail;*/


if (isset($_SESSION['username'])) {
    function GetUserEmail($username) {
		@ $db = mysqli_connect("localhost", "root", "", "products");
		$sql = "SELECT email FROM users WHERE username = '$username'";
		$result = mysqli_query($db, $sql);
		
		if ($result) {
			$row = mysqli_fetch_row($result);
			mysqli_free_result($result);
			mysqli_close($db);

			if ($row) {
				return $row[0];
			} else {
				return "Cannot find the user email";
			}
		} 
		else {
			return "Fail to connect: " . mysqli_error($db);
		}
}

    $username = $_SESSION['username'];
    $userEmail = GetUserEmail($username);
    $to = $userEmail; 
    $subject = 'Your order is created!';
    $message = "Dear $username,

Thank you for your order at FoodDash!

We are pleased to confirm that your order has been received and is now being processed. You will receive another email once your order has been dispatched.

Here are the details of your order:

Username: $username
Cart ID: $cartID
Contact Number: $contactNumber
Payment Method: $paymentMethod
Delivery Address: $deliveryAddress
Payment Amount: $totalPrice
Delivery Status: $deliveryStatus

Thank you for choosing FoodDash. We are committed to providing you with the best food delivery service. If you have any questions or need further assistance, please do not hesitate to contact us.

Best regards,
The FoodDash Team";

    $headers = 'From: ' . $userEmail . "\r\n" .
        'Reply-To: ' . $userEmail . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers,
        '-f' . $userEmail);

}?>
