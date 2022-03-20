<?php

    if (isset($_POST['room'])){

        include "db_connect.php";

        session_start();

        $username = $_SESSION['username'];
        $reported_user = addslashes($_POST['reporteduser']);
        $room = addslashes($_POST['room']);
        $room_name = addslashes($_POST['roomname']);
        $report_txt = addslashes($_POST['note']);
        
        $sql = "INSERT INTO reports (report_ID, report_txt, report_creator, report_offender, report_date, report_room)
        VALUES (NULL, '".$report_txt."', '".$username."', '".$reported_user."',  NULL,'".$room."')";

        if ($mysqli -> query($sql) === TRUE) {
            echo 'successful';
            header("Location: ../public/index.php?room=".$room."&roomname=".$room_name."");
        } else {
            echo 'error';
    }
}

?>