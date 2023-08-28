<?php
// Establish a database connection (replace with your own credentials)
$dbHost = "localhost";
$dbUser = "root";
// $dbPass = ""; /*to be determined*/
$dbName = "users_data";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user inputs from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Query to retrieve user from the database
$sql = "SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Redirect to the dashboard or perform further actions
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User not found.";
}

mysqli_close($conn);
?>