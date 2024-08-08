<?php
//for mail sending using mac
/*require "/Applications/XAMPP/xamppfiles/htdocs/mail_patch.php";
use function mail_patch\mail;*/

if (isset($_POST['email'])) {
    $username = $_POST['username'];
    $userEmail = $_POST['email'];
    $to = $userEmail; 
    $subject = 'Welcome to FOODDASH!';
    $message = "Dear $username, Welcome to FoodDash, your trusted food delivery partner! We're excited to have you on board and can't wait to serve you the best food from your favorite local restaurants.

Start your culinary journey with FoodDash today! Simply log in to your account and let us bring your favorite dishes to you.

Thank you for choosing FoodDash. We look forward to serving you delicious meals.

Best regards,
The FoodDash Team" ;
    $headers = 'From: ' . $userEmail . "\r\n" .
        'Reply-To: ' . $userEmail . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers,
        '-f' . $userEmail);

}?>
