<?php
include 'db_connect.php';


if (isset($_POST['room'])){

    $room = addslashes($_POST['room']);
    $json = addslashes($_POST['message']);
    $user = addslashes($_POST['user']);
    
    //Decode the JSON string and convert it into a PHP associative array.
    $sql = "INSERT INTO messages (message_ID, chat_name, message, message_user)
    VALUES (NULL, '".$room."', '".$json."', '$user')";

    if ($mysqli -> query($sql) === TRUE) {
        echo 'successful';
    } else {
        echo 'error';
    }

}
?>