<?php
    session_start();
    // $_SESSION['user_name']
    // $_SESSION["user_id"]
    // $_SESSION['token']

    if ( !isset($_SESSION['user_name']) ) 
        header( "Location: login_page.php" );
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chatting</title>
    <link rel="stylesheet" href="css/chatting_page.css" type="text/css" />
    <link rel="stylesheet" href="css/nav_bar.css" type="text/css" />
    <link rel="stylesheet" href="css/messages_table.css" type="text/css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript" src="js/refresh_table.js"></script>
    <script type="text/javascript" src="js/message_post.js"></script>

</head>
<body>
    <!-- NAVIGATION BAR -->
    <ul class="topnav">
        <li>
          <a id="username-logout"  href="logout.php" class="username-text" >
          <?php echo $_SESSION['user_name']; ?> 
          </a>
        </li>
    </ul>

    <!-- CONTENTS -->
    <div class="login-page">
        <div class="chat-box">
            
            <!-- new messages will posted inside the div below -->
            <div id="messages-box">No messages</div>

            <form id="login-form" class="login-form"  action="javascript:sendMessage('<?php echo $_SESSION["token"]; ?>', '<?php echo $_SESSION["user_id"]; ?>');"  >
                <input id="user-to-send" type="text" placeholder="username"/>
                <input id="message-field" type="text" autocomplete="off" placeholder="message"/>
                <button type="submit">send</button>
            </form>

        </div>
    </div>

</body>


<script language="javascript" type="text/javascript">
    // Script used to show/hide a 'logout' button when hovering on username
    $('#username-logout').hover(
        function() {
            var $this = $(this); 
            $this.data('initialText', $this.text());
            $this.addClass("logout-text")
            $this.text('Logout');
        },
        function() {
            var $this = $(this); 
            $this.text($this.data('initialText'));
            $this.removeClass("logout-text")
        }
    );

    // Start checking for new messages.
    // If there are any new messages they will posted in a table
    $(document).ready(function(){
        checkForNewMessages( "<?php echo $_SESSION['token']; ?>" , "<?php echo $_SESSION['user_id']; ?>");
    });
</script>

</html>