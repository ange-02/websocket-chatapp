<?php
    include 'db_connect.php';
    if (isset($_GET['room'])){
        if(isset($_POST['msg_ID'])){
            $lastmsg = addslashes($_POST['msg_ID']);
        
            $room = $_GET['room'];
            $sql = "SELECT Message_ID, message
                    FROM messages
                    WHERE chat_name = '".$room."' AND Message_ID < $lastmsg
                    ORDER BY Message_ID DESC
                    LIMIT 30";

            $result = mysqli_query($mysqli, $sql);
            
            while($row = mysqli_fetch_array($result)) {
                $messages_ajax[] = $row['message'];
                $message_ids = $row['Message_ID'];
            }


            echo '<a class="loadmore" id="'.$lastmsg.'">Load more...</a>';

            if ($result -> num_rows == 0) {
                $messages_ajax[] = [''];
                $message_ids = '';
            }
            echo 'aaa';
        } else { return 'aaa';} 
    }
?>