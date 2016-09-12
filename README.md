## Chat web application ##
Simple chat application. Just that :)


All the client-server communication is made over HTTP using POST method.
The communication is done according to the the api below, ie:
```
POST /chat_api/[function]
```
where [function] can be one of the:
  - login
  - post_message
  - refresh_table
  - check_for_new_messages

Also all the data transferred (sended or received) over HTTP are in JSON format.


The implementation of the app was made using: HTML,CSS,PHP, Javascript JQuery AJAX and SQLite.
