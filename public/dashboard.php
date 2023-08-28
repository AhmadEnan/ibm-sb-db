<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php 
        $uname = $_SESSION["username"];
        $uid = $_SESSION["userid"];

        echo "Username: " . $uname;
        echo "<br>";
        echo "User ID: " . $uid;
    ?>
</body>
</html>