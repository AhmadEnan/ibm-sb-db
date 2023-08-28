<?php
session_start();
if(($_SESSION["userid"]) > 0) {
    header('Location: public/dashboard.php');
}else
{
    header('Location: public/login.php');
}