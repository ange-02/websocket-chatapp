<?php

    $username = addslashes($_SESSION["username"]);

    $sql = "SELECT friends.user1, friends.user2, friends.status, users.user_name, users.user_icon
            FROM friends
            INNER JOIN users ON friends.user1 = users.user_name OR friends.user2 = users.user_name
            WHERE (friends.user1 = '".$username."' OR friends.user2 = '".$username."') AND status = 'friends' AND users.user_name != '".$username."'
            ORDER BY users.user_name";

    $result = $mysqli->query($sql);
    if ($result->num_rows === 0) {
        echo "<button class='sidebarbtn choice sidebtn'>No friends found</button>";
    } 
    $j = 0;
    while($row = mysqli_fetch_array($result)) {
        $users = array($row['user1'], $row['user2']);
        sort($users);
        if ($row['user1'] == $username) {
            echo "<button type='button' name='friends[]' class='sidebarbtn choice sidebtn friend' id='".$j."' value='".$row['user2']."' onclick=\"window.location.href='http://localhost/School/public/index.php?room=".$users[0].", ".$users[1]."'\"><span><img class='userpic' src='../files/pfp/".$row['user_icon']."' />".$row['user2']."</span></button> ";   // making sure that the other person is the friend
        } else {
            echo "<button type='button' name='friends[]' class='sidebarbtn choice sidebtn friend' id='".$j."' value='".$row['user1']."' onclick=\"window.location.href='http://localhost/School/public/index.php?room=".$users[0].", ".$users[1]."'\"><span><img class='userpic' src='../files/pfp/".$row['user_icon']."' />".$row['user1']."</span></button>";
        }
        $j++;
    }


?>