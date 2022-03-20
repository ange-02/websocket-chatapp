<?php

    session_start(); //sets session vars
    include "db_connect.php";
    $username = $_SESSION['username'];

    $text = $_POST["text"];
    $date = $_POST["date"];
    
    $users = json_decode($_POST['users']); // gets the JSON string and turns it into an array
    array_push($users, addslashes($username)); //adds the user themselves

    $to_search = join("','", $users);   // turns the array into a string with commas as separators
    $search = "SELECT DISTINCT userID
              FROM chatusers
              WHERE chatID IN ('$to_search')";  //search query to get an array of all the unique
                                                //users in the chats selected
    $search_result = $mysqli->query($search);

    while($row = mysqli_fetch_array($search_result)) {
        $sql = "INSERT INTO calendarevents (event_ID, event_user, event_date, event_text, event_creator)
        VALUES (NULL, '$row[0]', '$date', '$text', '$username')";
        if ($mysqli -> query($sql) === TRUE) {
            echo 'successful';
        } else {
            echo 'error';
        }     
    } 
    header('location: ../public/index.php?room=public&roomname=public');

?>