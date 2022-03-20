<?php
    include "db_connect.php";

    $username = addslashes($_SESSION["username"]);

    $sql = "SELECT chatID, userID, chat_name
            FROM chatusers
            WHERE userID = '".$username."' AND status = 'accepted'";

    $result = $mysqli->query($sql);
    if ($result->num_rows === 0) {
        echo "<button class='sidebarbtn choice sidebtn'>No chats found $username</button>";
    } 
    while($row = mysqli_fetch_array($result)) {            
            echo "<button name='room' onclick=\"window.location.href='http://localhost/School/public/index.php?room=".$row['chatID']."&roomname=".$row['chat_name']."'\" class='sidebarbtn choice sidebtn' id='friend'>".$row['chat_name']."</button> "; 
    }


?>