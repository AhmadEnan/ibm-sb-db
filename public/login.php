<!doctype html>
<html lang="en">
<head>
  <title>Login - IBMSB Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="styles/index.css">
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
<div class="section">
  <div class="container">
    <div class="row full-height justify-content-center">
      <div class="col-12 text-center align-self-center py-5">
        <div class="section pb-5 pt-5 pt-sm-2 text-center">
        <img src="https://www.freepnglogos.com/uploads/ibm-logo-png/ibm-logo-png-transparent-svg-vector-bie-supply-3.png">
          <div class="card-3d-wrap mx-auto">
            <div class="card-3d-wrapper">
              <div class="card-front">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="mb-4 pb-3">Log In</h4>
                    <form id="loginForm" action="../server/controllers/authenticate.php" method="POST">
                        <div class="form-group">
                            <input input type="email" id="email" name="email" required autocomplete="on" placeholder="Email" class="form-style">
                            <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                            <input input type="password" id="password" name="password" required autocomplete="on" placeholder="Password" class="form-style">
                            <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" name="submit" class="btn mt-4">Login</button>
                        <p type="forgot" id="forgot" name="forgot" class="mb-0 mt-4 text-center"><a href="login.php?error=forgot" class="link">Forgot your password?</a></p>
                    <?php 
                        if (isset($_GET['error'])) 
                        {
                            $val = $_GET['error'];
                            switch ($val) {
                                case 'forgot':
                                    echo '<p style="color: #FF6B6B;">Please refer to the server admin to reset your password.</p>';
                                    break;
                                
                                case 'usernotfound':
                                    echo '<p style="color: #FF6B6B;">Incorrect Email/Name!</p>';
                                    break;
                                
                                case 'incorrectpwd':
                                    echo '<p style="color: #FF6B6B;">Incorrect Password!</p>';
                                    break;
                                    
                                default:
                                    break;
                            }
                        }
                    ?>
                    </form>
                    </div>
                    </div>
                  </div>
              <div class="card-back">
                <div class="center-wrap">
                  <div class="section text-center">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

</body>
</html>
