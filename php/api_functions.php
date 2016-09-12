<?php    
    require_once("db_class.php"); 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function logInUser( $input_data ) {
        $_SESSION["user_name"] = $input_data["user_name"];
        $dbc = new SQLiteDB();
        $db_connection_success = $dbc->connect();

        // Check if there was any problem with the database
        if ( !$db_connection_success ) throw new Exception('Failed to access database.');

        if ( !$dbc->userExists($input_data["user_name"]) ){
            $uid = $dbc->createNewUser($input_data["user_name"]);
            $_SESSION["user_id"] = $uid;
        } else {
            $user = $dbc->getUserObjUsingUname( $input_data["user_name"] );
            $uid = $user->UID;
            $_SESSION["user_id"] = $uid;
        }
    }

    function addMessage( $input_data ) {

        $dbc = new SQLiteDB();
        $db_connection_success = $dbc->connect();

        // Check if there was any problem with the database
        if ( !$db_connection_success ) throw new Exception('Failed to access database.');

        // Match sender's ID and user's ID
        if ( $input_data['senders_id'] != $_SESSION["user_id"] ) throw new Exception("User's id doesn't match.");

        // Check if sender's username exists in the db
        if ( !$dbc->userExists($input_data["receivers_name"]) ) throw new Exception("No user with that username.");

        $dbc->addMessage(   $input_data['senders_id'], 
                            $input_data['receivers_name'], 
                            $input_data['text']);

        return true;
    }

    function refreshTable( $input_data ) {

        $dbc = new SQLiteDB();
        $dbc->connect();

        $usersid = $input_data['user_id'];
        $num_of_messages = $input_data['num_of_messages'];

        $messages_array = $dbc->getUsersMessages( $usersid, $num_of_messages);

        return $messages_array;
    }

    function checkForNewMessages( $input_data ) {

        $dbc = new SQLiteDB();
        $dbc->connect();

        $usersid = $input_data['user_id'];
        $last_messages_id = $input_data['last_messages_id'];

        $status = $dbc->checkUsersNewMessages( $usersid, $last_messages_id);

        return $status;
    }

?>