<?php

    if ($_SESSION['admin'] === 'yes' && isset($_GET['room'])){
        include 'db_connect.php';
        $room = $_GET['room'];
        $sql = "SELECT report_txt, report_creator, report_offender, report_room, report_date
                FROM reports
                ORDER BY report_date DESC";

        $result = $mysqli->query($sql);

        
        echo "<button class='sidebarbtn' id='reports'>Reports<i class='fas fa-flag'></i></button>";
        echo "<div id='reportsdiv' class='choice'>";
        echo "<button name='reportsdiv' class=\"sidebarbtn sidebtn\" id=\"backbtn\" name=\"mysettingsdiv\" onclick=\"goBack(this)\"><i class=\"fas fa-arrow-left\"></i> Back</button>";
        
        while($row = mysqli_fetch_array($result)) {            

            echo "<button onclick=\"window.location.href='http://localhost/School/public/index.php?room=".$row['report_room']."'\" class='sidebarbtn sidebtn' id='report'>";
            echo "<span id='note_user'>".$row['report_creator']."";
            echo "<span id='note_date'>".$row['report_date']."</span></span>";
            echo "<p id='note_msg'>".$row['report_txt']."</p>";
            echo "<span id='report_offender'><span id='reporting'>Reporting: </span>".$row['report_offender']."</span>";
            echo "</button>";

        }
        echo "</div>";
    }

?>