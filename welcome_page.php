<?php 
    session_start();
    if ( !isset($_SESSION['user_name']) ) 
        header( "Location: login_page.php" );
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
          Welcome to our chat <p class="username-text"><?php echo $_SESSION["user_name"]; ?></p> !
        </div>
    </div>
</body>

</html>

<?php 
  header( "refresh:1;url=chatting_page.php" );
?>