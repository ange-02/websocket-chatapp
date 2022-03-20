<?php

if(isset($_FILES['fileToUpload'])){
    include "db_connect.php";

    session_start();

    $room = $_POST['room'];
    $roomname = addslashes($_POST['roomname']);

    $target_dir = "../files/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $file_name = $_FILES['fileToUpload']['name'];
    $file_tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_err = $_FILES['fileToUpload']['error'];
    $file_type = $_FILES['fileToUpload']['type'];

    $fileExt = explode('.', $file_name);
    $fileActualExt = strtolower(end($fileExt));
    
    $allow = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'rtf', 'txt', 'blend', 'blend1', 'psd', 'zip'); #determining allowed file types

    if (in_array($fileActualExt, $allow)) {
        if ($file_err == 0) {
            if ($file_size < 50*1024*1024) { #50MB max filesize
                $filenameNew = uniqid('', true).".".$fileActualExt; #giving the file a unique id to avoid clashes
                $fileDestination = '../files/'.$filenameNew;
                move_uploaded_file($file_tmp_name, $fileDestination);


	            $sql = "INSERT INTO files
                        VALUES (NULL, '".$filenameNew."', '".$room."', '".$file_name."', NULL, '".$_SESSION['username']."')";
                
                $result = $mysqli->query($sql);
                if ($result === TRUE) {
                    header("Location: ../public/fileshare.php?room=".$room."&roomname=".$roomname."");
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