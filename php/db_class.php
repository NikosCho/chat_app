<?php 

/*  TODO:
*   - Find another way to check the database existence in connect()
*/

class SQLiteDB {

    protected $dbc; // database connection instance

    public function connect() {
        try {
            $location = 'sqlite:D:\_xampp\htdocs\php_chat\db\chat_db.sq3';
            $db  = new PDO($location); 

            // Enable exception on PDO, useful for debugging 
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

            // Make an test query on the database, that will throw
            // a PDOException if there is no such table.
            // eg Checking the existence of the db
            $check_db = $db->prepare("SELECT 1 FROM USERS ");
            $check_db->execute();

            $this->dbc = $db;
        } catch ( PDOException $e) {
            return  false;
        }
        return true;
    }

    /*  Executes any query on the database 
    *
    *   @returns true/false as success/fail
    */
    public function execQuery( $query ) {
        $db = $this->dbc;

        $command = $db->prepare( $query );
        $status = $command->execute();

        return $status;
    }

    /*  Checks user's existence based on the username
    *
    *   @returns true/false as exists/doesnt 
    */
    public function userExists( $username ) {
        $db = $this->dbc;

        //Used PDOStatement::fetchColumn as doesnt work on SQLite (also neede 'COUNT(*)' )
        $check_user = $db->prepare("SELECT COUNT(*) FROM USERS WHERE username='$username'");
        $check_user->execute();

        if ($check_user ->fetchColumn() > 0)  
            return true;
        else 
            return false;
    }

    /*  Find the user in the database using his ID.
    *
    *   @returns an object with the user data (UID, username).
    */
    public function getUserObjUsingID( $id ) {
        $db = $this->dbc;

        $getuser = $db->prepare("SELECT * FROM USERS WHERE UID='$id'");
        $getuser->execute();

        $user = $getuser->fetch(PDO::FETCH_OBJ); // Return row as an anonymous object with column names as properties

        return $user;
    }

    /*  Find the user in the database using his username.
    *
    *   @returns an object with the user data (UID, username).
    */
    public function getUserObjUsingUname( $username ) {
        $db = $this->dbc;

        $getuser = $db->prepare("SELECT * FROM USERS WHERE username='$username'");
        $getuser->execute();
        $user = $getuser->fetch(PDO::FETCH_OBJ); 

        return $user;
    }

    /*  Adds a new user's message to the db.
    *
    *   @returns the id of the user that was created. 
    *       If the returned ID is 0 there was a problem in the insertion.
    */
    public function createNewUser( $username ) {

        $success = $this->execQuery("INSERT INTO USERS (username) VALUES('$username')");

        if ( $success ) {
            $user = $this->getUserObjUsingUname( $username);
            return $user->UID;
        } else {
            return 0;
        }

        $db = $this->dbc;

        $insertnewuser = $db->prepare("INSERT INTO USERS (username) VALUES('$username')");
        if ( !$insertnewuser->execute() ) 
            return 0;

        $user = $this->getUserObjUsingUname( $username);
        return $user->UID;
    }



    /*  Adds a new user's message to the db.
    *
    *   @returns true/false according to the success/failure of the import
    */
    public function addMessage( $sender_id, $reciever_uname, $message_text ) {

        $receiver = $this->getUserObjUsingUname( $reciever_uname);
        $receiver_id = $receiver->UID;

        $status = $this->execQuery("INSERT INTO MESSAGES(s_UID, r_UID, mtext) VALUES('$sender_id','$receiver_id','$message_text')");

        return $status;
    }

    /*  Get the last "num_of_messages" user's messages (based on datetime).  
    *
    *   @returns an array containing all the data of the user's last messages.
    */
    public function getUsersMessages( $uid, $num_of_messages ) {
        $db = $this->dbc;

        $getmessages = $db->prepare("   SELECT MID, UTS.username AS SUN, UTR.username AS RUN, mtext, mdatetime  
                                        FROM MESSAGES MT 
                                        JOIN USERS UTS ON UTS.UID = MT.s_UID
                                        JOIN USERS UTR ON UTR.UID = MT.r_UID
                                        WHERE MT.r_UID='$uid' OR MT.s_UID='$uid'
                                        ORDER BY MID DESC LIMIT '$num_of_messages' ");

        $getmessages->execute();
        $messages_array = $getmessages->fetchAll();
        return $messages_array;
    }

    /*  Check for new users messages. Newer messager messages
    *   must have greater MID.
    *
    *   @returns an array with a status (if there were any new messages) 
    *        and the last user's message's ID. 
    */
    public function checkUsersNewMessages( $uid, $last_messages_id ) {

        $db = $this->dbc;

        $db_last_messages_id = $db->prepare("SELECT MID FROM MESSAGES WHERE r_UID='$uid' OR s_UID='$uid'
        ORDER BY MID DESC LIMIT 1 ");

        $db_last_messages_id->execute();

        $last_message = $db_last_messages_id->fetch(PDO::FETCH_OBJ);

        if ( $last_message->MID > $last_messages_id )
            return array( "status" => true, "last_id" => $last_message->MID);
        else 
            return array( "status" => false, "last_id" => $last_messages_id);
    }
} // END of SQLiteDB's class


?>
