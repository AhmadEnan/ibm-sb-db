<!-- login.php -->
<html>
    <head>
    <title>IBM SB - Login</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm" action="../server/controllers/authenticate.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="example@gmail.com" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>

        <button type="submit" name="submit">Login</button>
    </form>

    <?php 
    
    ?>
</body>
</html>
