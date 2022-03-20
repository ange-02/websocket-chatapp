<?php
    if (isset($_GET['room'])){
        $room = addslashes($_GET['room']);
        $sql = "SELECT file_name, file_ID, file_display_name, date_uploaded, user
                FROM files
                WHERE room_ID = '".$room."'
                ORDER BY date_uploaded DESC";

        $result = $mysqli->query($sql);

        #initialising the table
        echo "<table id='uploads'>";
        echo "<th>File number</th>";
        echo "<th>File name</th>";
        echo "<th>Uploaded by</th>";
        echo "<th>Date uploaded</th>";
        
        
        $count = 0;
        #iterating through the results of the query
        while($row = mysqli_fetch_array($result)) {
            $count++;
            #creating a row with the data from the query
            echo "<tr>";
            echo "<td>".$count."</td>";
            echo "<td><a class='filename' href='../files/".$row['file_name']."'>".$row['file_display_name']."</td>";
            echo "<td>".$row['user']."</td>";
            echo "<td>".$row['date_uploaded']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>