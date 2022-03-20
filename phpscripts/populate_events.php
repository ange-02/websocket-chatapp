<?php

include 'db_connect.php';
$username = addslashes($_SESSION["username"]);
$sql = "SELECT event_ID, event_user, event_date, event_text, event_creator
        FROM calendarevents
        WHERE event_user = '$username'
        ORDER BY event_ID DESC";

$result = $mysqli->query($sql);

while($row = mysqli_fetch_array($result)) {
    echo "<button class='sidebarbtn sidebtn' id='report'>";
    echo "<p>Set by: <span id='note_user'>".$row['event_creator']."</span></p>";
    echo "<p id='note_msg'>".$row['event_text']."</p>";
    echo "<span id='report_offender'><span id='reporting'>Due in: </span>".$row['event_date']."</span>";
    echo "</button>";
}

?>