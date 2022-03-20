<?php
    
    if (isset($_GET['room'])){
        include 'db_connect.php';
        $room = addslashes($_GET['room']);
        $sql = "SELECT note_msg, note_user, note_date, note_room
                FROM notes
                WHERE note_room = '".$room."'
                ORDER BY note_date DESC";

        $result = $mysqli->query($sql);
        
        while($row = mysqli_fetch_array($result)) {
            echo "<div id='notediv'>";
            echo "<span id='note_user'>".$row['note_user']."</span>";
            echo "<span id='note_date'>".$row['note_date']."</span>";
            echo "<p id='note_msg'>".$row['note_msg']."</p>";
            echo "</div>";
        }
    }

?>