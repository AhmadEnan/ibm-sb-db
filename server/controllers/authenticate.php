<?php

if(!(isset($_POST["submit"])))
{
    header("Location: ../../public/login.php");
    exit();
}

// Get user inputs from the form
$email = $_POST['email'];
$password = $_POST['password'];
require_once "dbh.php";
require_once "../functions/functions.php";

authUser($conn, $email, $password);