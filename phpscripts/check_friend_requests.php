<?php

    $user1 = $_SESSION["username"];

    $sql = "SELECT user1, user2
            FROM friends
            WHERE user2 = '".$user1."' AND status='pending'";

    $result = $mysqli->query($sql);
    if ($result->num_rows === 0) {
        echo "<button class='sidebarbtn choice sidebtn'>No Friend requests</button>";
    } 
    while($row = mysqli_fetch_array($result)) {
        echo "<a class='sidebarbtn choice sidebtn'>".$row['user1']."
                <form method='POST' id='add' action='../phpscripts/acceptfriend.php'>
                <button type='submit' id='addfriendsml' name='user' value='".$row['user1']."'><i id='plus' class='fas fa-plus'></i></button>
                </form>
              </a> ";
    }

?>