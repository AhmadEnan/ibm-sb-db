<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

$envdir = __FILE__;
$_SESSION["env_dir"] = str_replace('index.php', '', $envdir);

$_SESSION["api_instance_id"] = "7103852504";
$_SESSION["api_token"] = "f49e95943155403688e86b18ec641b9dcfe4db5e16b44fc4ba";

if(($_SESSION["userid"]) > 0) {
    header('Location: public/dashboard.php');
}else
{
    header('Location: public/login.php');
}