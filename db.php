<?php
$connection = mysqli_connect('localhost', 'root', '', 'products');
if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
$select_db = mysqli_select_db($connection, 'products');
if (!$select_db) {
    die("Database Selection Failed: " . mysqli_error($connection));
}
?>
