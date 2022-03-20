<?php

    session_start(); //hets session vars
    include "db_connect.php";
    $username = $_SESSION['username'];
    
    $users = json_decode($_POST['users']); // gets the JSON string and turns it into an array
    array_push($users, addslashes($username)); //adds the user themselves

    $chat_name = addslashes(implode(', ', $users));
    $unixtime = strtotime('now');
    $chat_id = ''.$chat_name.''.$unixtime.'';
    $chat_id = password_hash($chat_id, PASSWORD_DEFAULT);

    for($i = 0; $i < count($users); $i++) {
        $add = addslashes($users[$i]);
        $sql = "INSERT INTO chatusers (memberID, userID, chatID, status, chat_name)
        VALUES (NULL, '".$add."', '".$chat_id."', 'accepted', '".$chat_name."')";     
    }
    echo json_encode(array("location" => "index.php?room=".$chat_id."&roomname=".$chat_name.""));

?>