<?php 
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="css/welcome_logout_page.css" type="text/css" />
</head>

<body>
    <div class="login-page">
        <div class="welcome-box">
          Bye <p class="username-text"><?php echo $_SESSION["user_name"]; ?></p> !
        </div>
    </div>
</body>

</html>

<?php 
  session_destroy();
  header( "refresh:1;url=login_page.php" );
?>