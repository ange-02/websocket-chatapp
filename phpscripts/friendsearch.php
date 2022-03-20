<?php
    $myusername = $_SESSION['username'];
    if (isset($_GET["username"]) && $_GET["username"] != '') { // prevents empty searches
        $username = addslashes($_GET["username"]);

        $sql = "SELECT user_name
                FROM users
                WHERE user_name LIKE '%".$username."%' AND user_name != '".$myusername."' ";  // don't allow user to add themselves

        $result = $mysqli->query($sql);

        
        while($row = mysqli_fetch_array($result)) {
            echo "<div class='userfound'>
                    <h2 id='username'>".$row['user_name']."</h2>
                    <form id='add' action='../phpscripts/addfriend.php'>
                        <input id='hidden' name='search' value=".$username." />
                        <button type='submit' id='addfriend' name='user' value='".$row['user_name']."'>Add friend</button>
                    </form>
                </div>";
        }
    }

?>