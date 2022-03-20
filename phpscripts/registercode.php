<?php

include "db_connect.php";

$username = addslashes($_POST["username"]);
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

$class1 = addslashes($_POST['class1']);
$class2 = addslashes($_POST['class2']);
$class3 = addslashes($_POST['class3']);
$class_arr = array($class1, $class2, $class3);
if (isset($_POST['class4']) && $_POST['class4'] != '') {
    $class4 = addslashes($_POST['class4']);
    array_push($class_arr, $class4);
}

$sql = "INSERT INTO users (user_ID, user_name, user_pass, user_icon)
        VALUES (NULL, '".$username."', '".$hash."', 'default.png')";

$search = "SELECT user_name 
            FROM users
            WHERE user_name = '".$username."'";

$result = $mysqli->query($search);
if($result->num_rows > 0){
    echo "<p id='error'>Username is already taken!</p>";
} else{
    if ($mysqli->query($sql) === TRUE) {
        echo '<h3>Welcome,  '.$username.'!</h3>';
        echo "<p>You have created an account successfully!</p>";
        echo "<p>Click <span><a href = 'index.php?room=general'>here</a></span> to go to your homepage!";
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION['admin'] = 'no';
        $_SESSION['pfp'] = 'default.png';
        include "addtogeneralchat.php";

        for($i = 0; $i < count($class_arr); $i++) {
            $to_add = addslashes($class_arr[$i]);
            $classes_sql = "INSERT INTO classusers (userclass_ID, user_name, class_name)
                            VALUES (NULL, '".$username."', '".$to_add."')";
            if ($mysqli->query($classes_sql) === TRUE) {
                echo 'success';
            } else {
                echo $mysqli -> error();
            }

            $add_to_chat_sql = "INSERT INTO chatusers (memberID, userID, chatID, status, chat_name)
                                VALUES (NULL, '".$username."', '".$to_add."', 'accepted', '".$to_add."')";

            if ($mysqli->query($add_to_chat_sql) === TRUE) {
                echo 'success';
            } else {
                echo $mysqli -> error();
            }                
        }
        header('location: index.php?room=public&roomname=public');

    } 
}

?>