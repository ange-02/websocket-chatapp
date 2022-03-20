<?php

    if (isset($_POST['room'])){

        include "db_connect.php";

        session_start();

        $username = $_SESSION['username'];
        $room = addslashes($_POST['room']);
        $room_name = addslashes($_POST['roomname']);
        $note_txt = addslashes($_POST['note']);
        
        $sql = "INSERT INTO notes (note_ID, note_msg, note_user, note_date, note_room)
        VALUES (NULL, '".$note_txt."', '".$username."', NULL,'".$room."')";

        if ($mysqli -> query($sql) === TRUE) {
            echo 'successful';
            header("Location: ../public/fileshare.php?room=".$room."&roomname=".$roomname."");
        } else {
            echo 'error';
    }
}

?>