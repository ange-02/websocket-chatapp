<?php

    include "db_connect.php";

    session_start();

    $user2 = $_SESSION['username'];
    $user1 = addslashes($_POST['user']);

    $sql = "UPDATE `friends`
            SET `status` = 'friends'
            WHERE `user1` = '".$user1."' AND `user2` = '".$user2."'";

    if ($mysqli->query($sql) === TRUE) {
        header("location: http://localhost/School/public/index.php");
    } else {
        echo 'error';
    }    

?>