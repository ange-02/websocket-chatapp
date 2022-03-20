<!DOCTYPE html>
<html class="lightTheme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Home page</title>

    <?php 
        include '../phpscripts/db_connect.php';
        session_start();
        if ($_SESSION["username"]){
            setcookie("username", $_SESSION["username"]); 
        } else {
            header('location: login.php');
        }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script defer src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script src="scripts/script.js"></script>
    <link rel="stylesheet" href="homestyle.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />



</head>



<body>
<div id="overlay" onclick="off()"></div>
    <div class="gridcontainerfiles">

        <nav>
            <h1 id='titleName'>Hello!</h1>
            
        </nav>

        <div id="sidebar">
            <ul class="sidebar">
                
                <button class="sidebarbtn" id="mychats">My chats<i class="fas fa-comments"></i></button>
                <div id="mychatsdiv" class="choice">
                    <button class="sidebarbtn choice sidebtn" id="backbtn" name="mychatsdiv" onclick="goBack(this)"><i class="fas fa-arrow-left"></i> Back</button>
                    <div id="chat-creator">
                        <button class="sidebarbtn choice sidebtn" id="createchat">Create a chat<i class="fas fa-comment-medical"></i></button>    
                        <div id="friendlist" class="hidden">
                            <?php
                                include "../phpscripts/populate_friends.php";
                                echo "<button class='sidebarbtn choice sidebtn' id='create'>Go!</button>";
                            ?>
                        </div>
                    </div>
                    <br>
                    <input type="text" class="searchbar sidebar choice sidebtn" placeholder="search chats..." autocomplete="off"/>

                    <?php

                        include "../phpscripts/db_connect.php";
                        include "../phpscripts/populate_chats.php";

                    ?>      
                </div>

                <button class="sidebarbtn" id="myfriends">My friends<i class="fas fa-user-friends"></i></i></button>
                <div id="myfriendsdiv" class="choice">
                    <button class="sidebarbtn choice sidebtn" id="backbtn" name="myfriendsdiv" onclick="goBack(this)"><i class="fas fa-arrow-left"></i> Back</button>
                    <a class="hidden_a_tag" href="addfriends.php"><button class="sidebarbtn choice sidebtn">Add a friend <i class="fas fa-user-plus"></i></button></a>            
                    <input type="text" class="searchbar sidebar choice sidebtn" placeholder="search for friends..." autocomplete="off"/>
                    <?php

                        include "../phpscripts/db_connect.php";
                        include "../phpscripts/populate_friends.php";

                    ?>

                    <?php

                        include "../phpscripts/db_connect.php";
                        include "../phpscripts/check_friend_requests.php";

                    ?>

                </div>

                
                <button class="sidebarbtn" id="mycalendar">Calendar<i class="fas fa-bell"></i></button>

                <?php include "../phpscripts/populate_reports.php"; ?>
                
                <button class="sidebarbtn" id="mysettings">Settings<i class="fas fa-cog"></i></button>
                <div id="mysettingsdiv" class="choice">
                    <button class="sidebarbtn choice sidebtn" id="backbtn" name="mysettingsdiv" onclick="goBack(this)"><i class="fas fa-arrow-left"></i> Back</button>
                    <button class="sidebarbtn choice sidebtn" id="darkchoice" href="myprofile.html">My profile <i class="fas fa-user-circle"></i></button>
                    <button class="sidebarbtn choice sidebtn" id="darkchoice" onclick="toggleTheme()">Change Theme <i class="fas fa-moon"></i></button>
                </div>

            </ul>
        </div>


        <div id="memberbar" class="scroll">
            <p id="member_name">Notes:</p>
            <button type="button" onclick="on(this)" id="addnote" class="button"><i class="fas fa-sticky-note"></i></button>
            <?php include "../phpscripts/populate_notes.php"; ?>
        </div>

        <form class="show-on-overlay" id="addnote-form" action="../phpscripts/add_note.php" method="POST" enctype="multipart/form-data">
            <h1 id="file-upload-title"> Enter a note: </h1>
            <input class="hidden" name="room" value=<?php echo $_GET['room'];?> />
            <input class="hidden" name="roomname" value="<?php echo addslashes($_GET['roomname']); ?>" />
            <textarea maxlength="100" class="searchbar" name="note" id="noteToSend" required ></textarea>
            <span id="charcount">0/100</span>
            <button class="button" type="submit" id="uploadfile"><i class="far fa-paper-plane"></i></button>
        </form>


        <div class="scroll messagediv filediv">
            <div class="message">
                <span id="welcome">Files for this chat</span>
            </div>
            <br>
            <?php
                    include "../phpscripts/db_connect.php";
                    include "../phpscripts/populate_uploads.php";
                ?>
        </div>

        <form class="show-on-overlay" id="sendfile-form" action="../phpscripts/uploadfile.php" method="POST" enctype="multipart/form-data">
            <h1 id="file-upload-title"> Select a file: </h1>
            <input class="hidden" name="room" value=<?php echo $_GET['room'];?> />
            <input class="hidden" name="roomname" value="<?php echo addslashes($_GET['roomname']); ?>" />
            <input type="file" name="fileToUpload" id="fileToUpload" required/>
            <button class="button" type="submit" id="uploadfile"><i class="far fa-paper-plane"></i></button>            
        </form>
        <button type="button" onclick="on(this)" id="sendfile" class="button"><i class="fas fa-folder-plus"></i></button>
    </div>

    </div>
</body>


<script src="scripts/sidebar.js"></script>
<script src="scripts/friendadds.js"></script>
<script src="scripts/editchatname.js"></script>
<script src="scripts/uploadfiles-clientside.js"></script>

</html>