<?php

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags)
    {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function userExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../public/login.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else return false;

    mysqli_stmt_close($stmt);
}

function authUser($conn, $email, $password)
{
    $exists = userExists($conn, $email);
    if($exists === false){
        header("Location: ../../public/login.php?error=usernotfound");
        exit();
    }

    if($password === $exists["user_pwd"]){
        console_log("Success! starting a session");
        session_start();
        $_SESSION["userid"] = $exists["user_id"];
        $_SESSION["username"] = $exists["user_name"];
        header("Location: ../../public/dashboard.php");
    }else{
        header("Location: ../../public/login.php?error=incorrectpwd");
        exit();
    }
}