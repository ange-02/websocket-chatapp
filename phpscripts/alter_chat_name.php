<?php 

    include "db_connect.php";

    $room_ID = addslasheS($_POST['room_ID']);
    $new_name = addslashes($_POST['chat_name']);

    $sql = "UPDATE chatusers
            SET chat_name = '".$new_name."'
            WHERE chatID = '".$room_ID."'";

    if ($mysqli->query($sql) === TRUE){
        echo 'success';
    } else {
        echo $mysqli->error;
    }

?>