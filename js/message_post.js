function sendMessage( user_token, user_id  ){

    var message_data = {
        "token"         : user_token                            ,
        "senders_id"    : user_id                               ,
        "receivers_name": $('input[id="user-to-send"]').val()   ,
        "text"          : $('input[id="message-field"]').val()  };

    var message_json = JSON.stringify(message_data);

    $.ajax({
        type: "POST", 
        url: "chat_api/post_message",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data:  message_json,
        success: function(response) {
            if ( response.status ) {
                getLastMessages( user_token, user_id );
            } else if ( !response.status ) {
                alert(response.message);
            } else {
                alert("undefined error");
            }
        } 
    });

    $('#message-field').val("");
};
