<?php
require_once "C:/xampp/htdocs/ibm/vendor/autoload.php"; // Include the Composer autoloader

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Utils;

// Updates all the global variables in the current session
function updateSessionVariables($user)
{
    if(!session_status() === PHP_SESSION_ACTIVE) session_start();

    $_SESSION["userid"] = $user["user_id"];
    $_SESSION["username"] = $user["user_name"];
    $_SESSION["bulk"] = $user["send_bulk"];
    $_SESSION["admin"] = $user["admin_control"];
}

// Finds if the user exists or not using their user name OR email
// returns the row that contains their data
function userExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE user_email = ? OR user_name = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../../public/login.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else return false;

    mysqli_stmt_close($stmt);
}

// Authenticate the User, checks their credintials before
// allowing them to access the dashboard
function authUser($conn, $email, $password)
{
    $exists = userExists($conn, $email);
    if($exists === false){
        header("Location: ../../public/login.php?error=usernotfound");
        exit();
    }

    if($password === $exists["user_pwd"]){
        session_start();
        updateSessionVariables($exists);
        header("Location: ../../public/dashboard.php");
    }else{
        header("Location: ../../public/login.php?error=incorrectpwd");
        exit();
    }
}

// Changes the value of anything in the database
function setValue($conn, $userName, $fieldName, $value)
{
    // Make sure user actually exists
    $exists = userExists($conn, $userName);
    if($exists === false){
        echo "User Doesn't Exist";
        exit();
    }
    
    // Update the table with the new data
    $sql = "UPDATE users SET " . $fieldName . " = " . $value . " WHERE users.user_id = " . $exists["user_id"] . ";";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error in Statement";
        exit();
    }
    mysqli_stmt_execute($stmt);

    // Update session variables (just to keep the page up-to date)
    updateSessionVariables($exists);
}

function sendWhatsappMessage($phoneNumber, $message)
{
    $id = $_SESSION["api_instance_id"];
    $instance = $_SESSION["api_token"];
    $url = "https://api.green-api.com/waInstance" . $id . "/sendMessage/" . $instance;

    $data = array(
        'chatId' => $phoneNumber . '@c.us',
        'message' => $message . "\n\n**This message was sent through the IBM SkillsBuild Dashboard, I'm Probably testing something so, Please ignore it**"
    );

    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);

    $response = file_get_contents($url, false, $context);
    echo $response;
}



function sendWhatsappFile($phoneNumber, $file)
{

    $id = $_SESSION["api_instance_id"];
    $instance = $_SESSION["api_token"];
    $url = "https://api.green-api.com/waInstance" . $id . "/sendFileByUpload/" . $instance;

    $httpClient = new Client();

    // Get the original file name
    $originalFileName = $file['name'];

    // Define the target directory where you want to store the uploaded files
    $targetDirectory = "uploads/"; // Create this directory in your project

    // Generate a unique name for the uploaded file
    $uniqueFileName = uniqid() . '_' . $originalFileName;

    // Move the uploaded file to the target directory with the unique name
    $uploadPath = $targetDirectory . $uniqueFileName;

    move_uploaded_file($file['tmp_name'], $uploadPath);

    $multipartStream = new MultipartStream([
        [
            'name' => 'chatId',
            'contents' => $phoneNumber . '@c.us',
        ],
        [
            'name' => 'caption',
            'contents' => '',
        ],
        [
            'name' => 'file',
            'contents' => fopen($uploadPath, 'rb'),
            'filename' => $originalFileName, // Set the original file name
        ],
    ]);

    $request = new Request('POST', $url, [
        'Content-Type' => 'multipart/form-data; boundary=' . $multipartStream->getBoundary(),
    ], $multipartStream);

    try {
        $response = $httpClient->send($request);

        if ($response->getStatusCode() === 200) {
            echo '[Response]: ' . $response->getBody();
        } else {
            echo '[ERROR ' . $response->getStatusCode() . ']: ' . $response->getReasonPhrase() . ' ' . $response->getBody();
        }
    } catch (GuzzleHttp\Exception\RequestException $e) {
        echo 'Guzzle Exception: ' . $e->getMessage();
    }
}