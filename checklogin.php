<?php
session_start(); 

if (isset($_SESSION['username'])) {
    header("Location: about.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>