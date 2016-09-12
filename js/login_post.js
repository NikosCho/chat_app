function logIn( user_token ){

    var data = {
        "token"         : user_token                            ,
        "user_name"     : $('input[id="username-field"]').val() };

    var json_data = JSON.stringify(data);

    $.ajax({
        type: "POST", 
        url: "chat_api/login",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data:  json_data,
        success: function(response) {
            if ( response.status ) {
                window.location.href = "welcome_page.php";
            } else if ( !response.status ) {
                alert(response.message);
            } else {
                alert("undefined error");
            }
        } 
    });
};































// ajax debugging ERROR's response

    //   error: function (jqXHR, exception) {
    //     var msg = '';
    //     if (jqXHR.status === 0) {
    //         msg = 'Not connect.\n Verify Network.';
    //     } else if (jqXHR.status == 404) {
    //         msg = 'Requested page not found. [404]';
    //     } else if (jqXHR.status == 500) {
    //         msg = 'Internal Server Error [500].';
    //     } else if (exception === 'parsererror') {
    //         msg = 'Requested JSON parse failed.';
    //     } else if (exception === 'timeout') {
    //         msg = 'Time out error.';
    //     } else if (exception === 'abort') {
    //         msg = 'Ajax request aborted.';
    //     } else {
    //         msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //     }
    //     alert(msg);
    // } 