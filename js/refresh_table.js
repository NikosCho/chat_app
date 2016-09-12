
function checkForNewMessages( user_token, user_id, last_messages_id = 0 ) {

    var data = {
        "token"             : user_token        ,
        "user_id"           : user_id           ,
        "last_messages_id"  : last_messages_id  };

    var json_data = JSON.stringify(data);

    $.ajax({
        type: "POST",
        url: "chat_api/check_for_new_messages",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data:  json_data,
        success: function(response) {
            var last_mid = response.data; // the 'data' returned is the MID of the last user's message
            
            if ( response.status ) // If there any new messages
                getLastMessages(user_token, user_id); 

            // Periodically check for new messages
            setTimeout(function() { checkForNewMessages(user_token, user_id, last_mid); }, 5000);
        } 
    });

    return status;
}


function getLastMessages( user_token, user_id ) {

    var last_messages_id = 0;

    var data = {
        "token"             : user_token        ,
        "user_id"           : user_id           ,
        "num_of_messages"   : 10               };

    var json_data = JSON.stringify(data);

    $.ajax({
        type: "POST", 
        url: "chat_api/get_users_messages",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data:  json_data,
        success: function(response) {
            if ( response.status ) {
                last_messages_id = createTable(response.message);
            } else if ( !response.status ) {
                alert(response.message);
            } else {
                alert("undefined error");
            }
        } 
    });

    return last_messages_id;
}


function createTable( messages_array ) {

    var tbl_body = "<table> <col width=5%> <col width=15%> <col width=80%>";
    var odd_even = false;
    var tr;

    for (var i = messages_array.length - 1; i >=0; i--) {
        tr = "<tr class=\"" + ( odd_even ? "odd" : "even") + "\">" ;
        tr +="<td class=\"message-id\">" + messages_array[i].SUN + "</td>";
        tr +="<td class=\"message-sender\">" + messages_array[i].RUN + "</td>";
        tr +="<td>" + messages_array[i].mtext + "</td>";
        tr +="</tr>";

        tbl_body += tr; 
        odd_even = !odd_even;      
    }

    tbl_body +="</table>"; 
    $("#messages-box").html(tbl_body);

    var last_messages_ID = messages_array[messages_array.length - 1].MID;

    return last_messages_ID;
}



