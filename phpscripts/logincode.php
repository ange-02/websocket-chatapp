<?php

$username = addslashes($_POST["username"]);
$password = $_POST["password"];

$sql = "SELECT user_ID, user_name, user_pass, admin_privileges, user_icon
        FROM users
        WHERE user_name = '".$username."'";

$result = $mysqli->query($sql);

if($result->num_rows > 0){
  $row = $result -> fetch_assoc();
  if (password_verify($password, $row['user_pass'])){
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['admin'] = $row['admin_privileges'];
    $_SESSION['pfp'] = $row['user_icon'];
    header('location: index.php?room=public&roomname=public');
  } else {
    echo '<p>Wrong login details!</p>';
  }
} else { 
  echo '<p>Wrong login details!</p>';
}

?>