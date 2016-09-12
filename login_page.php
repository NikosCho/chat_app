<?php
    session_start();

    // Create a user token for authentication
    if ( !isset($_SESSION['token']) ) {
        $token = md5(rand(1000,9999)); //you can use any encryption
        $_SESSION['token'] = $token; 
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Chat Log in</title>
    <link rel="stylesheet" href="css/login_page.css" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>
    <div class="login-page">
        <div class="form">
        <form id="login-form" class="login-form" action="javascript:logIn('<?php echo $_SESSION["token"]; ?>');" >
            <input id="username-field" type="text" placeholder="username"/>
            <button type="submit">login</button>
            <p class="message">If it is your first time, you will be auto-registered!</p>
        </form>
        </div>
    </div>
</body>

<script type="text/javascript" src="js/login_post.js"></script>

</html>



