<?php 

    include "db_connect.php";

    session_start();
    
    $user1 = addslashes($_SESSION["username"]);
    $user2 = addslashes($_GET["user"]);
    $return_to = addslashes($_GET["search"]);

    $sql = "INSERT INTO friends (friendship_ID, user1, user2, status)
            VALUES (NULL, '".$user1."', '".$user2."', 'pending')";

    $search = "SELECT user1
                FROM friends
                WHERE user1 = '".$user1."' AND user2 = '".$user2."'";

    $result = $mysqli->query($search);

    if ($result->num_rows == 0) {
        if ($mysqli->query($sql) === TRUE) {
            header("location: http://localhost/School/public/addfriends.php?username=".$return_to."");
        } else {
            echo $mysqli -> error;
        }    
    } else {
        header("location: http://localhost/School/public/addfriends.php?username=".$return_to."");
    }

?>