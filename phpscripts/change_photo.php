<?php
if(isset($_FILES['photoUpload'])){
    include "db_connect.php";

    session_start();

    $room = $_POST['room'];
    $roomname = addslashes($_POST['roomname']);

    $target_dir = "../files/pfp/";
    $target_file = $target_dir . basename($_FILES["photoUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $file_name = $_FILES['photoUpload']['name'];
    $file_tmp_name = $_FILES['photoUpload']['tmp_name'];
    $file_size = $_FILES['photoUpload']['size'];
    $file_err = $_FILES['photoUpload']['error'];
    $file_type = $_FILES['photoUpload']['type'];

    $fileExt = explode('.', $file_name);
    $fileActualExt = strtolower(end($fileExt));
    
    $allow = array('jpg', 'jpeg', 'png'); #determining allowed file types
    
    if (in_array($fileActualExt, $allow)) {
        if ($file_err == 0) {
            if ($file_size < 5*1024*1024) { #5MB max filesize
                $filenameNew = uniqid('', true).".".$fileActualExt; #giving the file a unique id to avoid clashes
                $fileDestination = '../files/pfp/'.$filenameNew;
                move_uploaded_file($file_tmp_name, $fileDestination);


	            $sql = "UPDATE users
                        SET user_icon = '$filenameNew'
                        WHERE user_name = '".$_SESSION['username']."'";

                $delete_query = "SELECT user_icon
                                 FROM users
                                 WHERE user_name = '".$_SESSION['username']."'";

                $to_delete = $mysqli->query($delete_query);
                $row_delete = $to_delete -> fetch_assoc();
                unlink("../files/pfp/".$row_delete['user_icon'].""); // Dletes the current profile picture of the user, to save space
                
                $result = $mysqli->query($sql);
                if ($result === TRUE) {
                    $_SESSION["pfp"] = $filenameNew;
                    setcookie("pfp", $filenameNew);
                    header("Location: ../public/index.php?room=".$room."&roomname=".$roomname."");
                } else {
                    $error_report = $mysqli->error;
                    echo $error_report;
                    echo "could not upload your post...";
                }
                echo "success";
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo $mysqli->error;
            echo "There was an error uploading your file :(";
        }
    } else {
        echo "This file type is not supported!";
    }
} 
        

?>