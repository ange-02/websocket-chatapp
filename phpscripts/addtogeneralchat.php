<?php

    session_start();
    $room_to_join = "public";
    $username = $_SESSION['username'];

    $sql = "INSERT INTO chatusers (memberID, userID, chatID, status, chat_name)
        VALUES (NULL, '".$username."', '".$room_to_join."', 'accepted', 'public')";

    if ($mysqli -> query($sql) === TRUE) {
        echo 'successful';
    } else {
        echo 'error';
    }

?>