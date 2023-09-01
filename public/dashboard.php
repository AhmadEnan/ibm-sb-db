<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" rel="stylesheet">
    <title>IBM - Bulk Messaging</title>

</head>

<body>
    <div class="container">
        <h1>Bulk Messaging</h1>
        <form id="contactForm" action="dashboard.php" method="POST" enctype="multipart/form-data">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" cols="50" placeholder="Write your message" value="<?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES) : ''; ?>" ></textarea>
            
            <label for="phoneNumbers">Phone Numbers:</label>
            <input type="text" id="phoneNumbers" name="phoneNumbers" placeholder="Enter phone numbers" value="<?php echo isset($_POST['phoneNumbers']) ? htmlspecialchars($_POST['phoneNumbers'], ENT_QUOTES) : ''; ?>">
            
            <button type="submit">Send</button>

            <h1>Upload a File</h1>
            <label for="file">Choose a file:</label>
            <input type="file" name="file" id="file">
            <input type="submit" value="Send File">
        </form>
    </div>

    <?php
      require_once "../server/functions/functions.php";
      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $file;
        if(isset($_FILES['file']))
        {
           $file = $_FILES['file'];
        }else {
            echo "Error: User didn't choose a file!";
        }

        $message = $_POST["message"];
        $phoneNumbers = explode(',', $_POST["phoneNumbers"]);
    
        // Now you can do whatever you want with the $message and $phoneNumbers variables.
        // For this example, we'll just print them.
        echo "Message: " . $message . "<br>";
        
        foreach ($phoneNumbers as $number) {
          echo "Sending message to: " . $number . "<br>";
          // sendWhatsappMessage($number, $message);
          sendWhatsappFile($number, $file);
        }

      }
      
      ?>
</body>
</html>


<!-- <?php
    
    // require_once "../server/controllers/dbh.php";
    // require_once "../server/functions/functions.php";
    
    // $uname = $_SESSION["username"];
    // $uid = $_SESSION["userid"];
    // $ubulk = $_SESSION["bulk"];
    // $uadmin = $_SESSION["admin"];

    // echo "Username: " . $uname;
    // echo "<br>";

    // echo "User ID: " . $uid;
    // echo "<br>";

    // echo "Can Send Bulk Messages: ";
    // if($ubulk) echo "Yes";
    // else echo "No";
    // echo "<br>";

    // echo "Has Access to the Control Panel: ";
    // if($uadmin) echo "Yes";
    // else echo "No";
// ?>
