<?php
    include 'db_connect.php';
    if (isset($_GET['room'])){
        $room = addslashes($_GET['room']);
        $sql = "SELECT messages.Message_ID, messages.message, messages.chat_name, users.user_icon
                FROM messages
                INNER JOIN users ON messages.message_user = users.user_name
                WHERE chat_name = '$room'
                ORDER BY Message_ID DESC";

        $result = mysqli_query($mysqli, $sql);
        
        while($row = mysqli_fetch_array($result)) {
            $messages[] = $row['message'];
            $pfp[] = $row['user_icon'];
        }

        if ($result -> num_rows == 0) {
            $messages = '';
            $pfp = '';
        }
    }
?>