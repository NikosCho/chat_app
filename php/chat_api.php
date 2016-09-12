<?php 

    session_start();
    require_once("api_functions.php"); 

    try {
        // Check request type
        if( $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') throw new Exception('Not an AJAX request.');

        $input_data = file_get_contents("php://input");
        $data = json_decode($input_data, true);

        // Check user's token
        if ( $data["token"] != $_SESSION['token'] ) throw new Exception('Invalid token.');

        // Get function's type. How to handle the request
        $url_elements = explode('/', $_SERVER['PATH_INFO']);
        $function = $url_elements[1];

        // Handle the request according to its requested function
        switch ($function) {
            case 'login':
                logInUser($data);
                respondToRequest(true);
                break;
            case 'post_message':
                $result = addMessage($data);
                respondToRequest($result);
                break;
            case 'get_users_messages':
                $result = refreshTable($data);
                respondToRequest(true, $result);
                break;
            case 'check_for_new_messages':
                $result = checkForNewMessages($data);
                // respondToRequest($result);
                respondToRequest($result["status"], null, $result["last_id"]);
                break;
            default:
                respondToRequest(false, "Unknown function requested.");
                break;
        }

    } catch (Exception $e) {
        respondToRequest(false, "Request failed:".$e);
    }

    // The following function will be used to respond to the client 
    // Response` contains:
    // - 'status' -> if the request to the api was succesful
    // - 'message' -> It contains a message ( mainly used for errors )
    // - 'data' -> It contains either the requested data 
    function respondToRequest( $status, $message = null, $data = null ) {
        $response_to_request = array("status"=>$status, "message" => $message, "data" => $data);
        header('Content-Type: application/json');
        echo json_encode($response_to_request);
    }


?>
