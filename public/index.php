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
            setcookie("pfp", $_SESSION["pfp"]);
            $red = rand(0, 255);
            $green = rand(0, 255);
            $blue = rand(0, 255);
            $color_arr = array($red, $green, $blue);
            setcookie("color", implode($color_arr, ", "));
            include '../phpscripts/populate_msg.php';
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
    <div class="gridcontainer">

        <nav>
            <h1 id='titleName'>Hello!</h1>
            <div id='editor-container'>
                <button id="edit-chat-name" class="button"><i class="fas fa-edit"></i></button>
                <div id="name-editor" class="hidden">
                    <a id="closetab"> X </a><br>
                    <input id='edit-chat-input' type="text" class="searchbar" placeholder="enter new name..." autocomplete="off"/> <br>
                    <p class="smltxt" id="chat-name-notif"></p>
                    <button class="button" id='confirm-name-change'>Go!</button> 
                </div>
             </div>
             <button id="file-channel" class="button" /><i class="fas fa-folder-open"></i></button>
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
                <div id="mycalendardiv" class="choice">
                    <button class="sidebarbtn choice sidebtn" id="backbtn" name="mycalendardiv" onclick="goBack(this)"><i class="fas fa-arrow-left"></i> Back</button>
                    <div id="event-creator">
                    <?php 

                        include "../phpscripts/db_connect.php";
                        if ($_SESSION["admin"] == "yes") {
                            echo "<button type='button' class='sidebarbtn choice sidebtn' id='createevent'>Create an event<i class='far fa-calendar-plus'></i></button>";
                        }

                    ?>
                    <div id="participantlist" class="hidden">
                            <?php
                            if ($_SESSION["admin"] == "yes") {
                                echo "<p class='sidebar choice sidebtn'>Event details:</p>";
                                echo "<textarea id='eventtxt' name='event_name' class='searchbar sidebar choice sidebtn' placeholder='enter a description for the event:' maxlength=100 required> </textarea>";
                                echo "<input id='eventdate' type='text' name='event_date' class='searchbar sidebar choice sidebtn' placeholder='enter a date for the event:' maxlength=40 required/>";
                                include "../phpscripts/populate_chats.php";
                                echo "<button class='sidebarbtn choice sidebtn' id='eventcreate'>Go!</button>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php include "../phpscripts/populate_events.php"; ?>
                </div>


                <?php include "../phpscripts/populate_reports.php"; ?>

                
                <button class="sidebarbtn" id="mysettings">Settings<i class="fas fa-cog"></i></button>
                <div id="mysettingsdiv" class="choice">
                    <button class="sidebarbtn choice sidebtn" id="backbtn" name="mysettingsdiv" onclick="goBack(this)"><i class="fas fa-arrow-left"></i> Back</button>
                    <button class="sidebarbtn choice sidebtn" id="changephoto" onclick="on(this)">Change photo <i class="fas fa-user-circle"></i></button>
                    <button class="sidebarbtn choice sidebtn" id="darkchoice" onclick="toggleTheme()">Change Theme <i class="fas fa-moon"></i></button>
                </div>
            </ul>


        </div>


        <div id="memberbar" class="scroll">
            <p id="member_name">Users:</p>
            <button type="button" onclick="on(this)" id="addnote" class="button"><i class="fas fa-flag"></i></i></button>
        </div>
 
        <form id="changephoto-form" class="show-on-overlay" action="../phpscripts/change_photo.php" method="POST" enctype="multipart/form-data">
            <h1 id="file-upload-title"> Select new photo: </h1>
            <input class="hidden" name="room" value=<?php echo $_GET['room'];?> />
            <input class="hidden" name="roomname" value="<?php echo addslashes($_GET['roomname']); ?>" />
            <input type="file" name="photoUpload" id="fileToUpload" required/>
            <button class="button" type="submit" id="uploadfile"><i class="far fa-paper-plane"></i></button>   
        </form>

        <form class="show-on-overlay" id="addnote-form" action="../phpscripts/create_report.php" method="POST" enctype="multipart/form-data">
            <h1 id="file-upload-title"> Give us a description of what happened: </h1>
            <input class="hidden" name="room" value=<?php echo $_GET['room'];?> />
            <input class="hidden" name="roomname" value="<?php echo addslashes($_GET['roomname']); ?>" />
            <textarea maxlength="300" class="searchbar" name="note" id="noteToSend" required ></textarea>
            <span id="charcountreport">0/300</span>
            <br>
            <input type="text" name="reporteduser" class="searchbar" id="reporteduser" placeholder="Tell us who you're reporting" />
            <button class="button" type="submit" id="uploadfile"><i class="far fa-paper-plane"></i></button>
        </form>


        <div class="scroll messagediv">
            <div class="message">
                <span id="welcome">Welcome to the chat!</span>
            </div>
        </div>


        <form id="inputfield">
            <textarea name="message" id="msginput" autocomplete="off" required></textarea>
            <!-- <button type="submit" id="sendmsg" class="button"><i class="fas fa-paper-plane"></i></button> -->
        </form>
    </div>

    </div>
</body>


<script type="text/javascript">
    function getCookie(cname) {
        //getting the cookies stored in the browser
        var cookie = document.cookie
            // splitting the cookie into indivitual parts
        cookie = cookie.split(' ')
        for (i = 0; i < cookie.length; i++) {
            currentcookie = cookie[i].split('=')
                // returning the value of the cookie. Not including the last letter as that will
                //always be a semi-colon
            if (currentcookie[0] === cname) return currentcookie[1].substr(0, currentcookie[1].length - 1)
        }
    }


    var msgs = <?php echo json_encode($messages); ?>;
    var pfp = <?php echo json_encode($pfp); ?>;
    var user = getCookie('username')

    if (msgs.length >= 30) {
        //loadmore = document.createElement("a")
        //loadmore.innerHTML = "Load more messages";
        //var msgids = <?php //echo json_decode($message_ids); ?>;
        //console.log(msgids)
        //loadmore.id = msgids;
        //loadmore.className = 'loadmore';
        //$('.messagediv').append(loadmore)
    }



    //$('.loadmore').click(() => {
        // $('.loadmore').load("../phpscripts/load_more_ajax.php", {
        //     msg_ID: $('.loadmore').attr("id")
        // });
        // var ajaxmsg = <?php //echo json_encode($messages_ajax); ?>;
        // for(j = ajaxmsg.length -1; j > 0; j--) {
        //     format_msg(ajaxmsg[j])
        // $.ajax({
        //     url: '../phpscripts/load_more_ajax.php',
        //     type: 'post',
        //     data: {
        //         msg_ID: $('.loadmore').attr('id')
        //     }, success:function(response){
        //         console.log(`successfully sent ${$('.loadmore').attr('id')}`)
        //     }
        //     });
    //})
    

    function format_msg(obj, pfp) {
        object = JSON.parse(obj);   // transforming the strings back to objects.
        pfp
        //checking whether the user who is logged in has sent the message or 
        // whether it was another user, in order to know what id to give it so it can have the correct css 
        if (user == object['username']) {
            var who = 'myMessage'
            var where = 'rightsmltxt'
        } else {
            var who = 'message'
            var where = 'leftsmltxt'
        }

        timespan = document.createElement("span");
        //getting the time from when the message was sent
        timespan.append(moment(object['timeStored']).fromNow());
        timespan.id = 'smltxt';

        userspan = document.createElement("p");
        userspan.className = 'msginfo';
        userspan.append(object["username"]);
        userspan.id = where;
        userspan.appendChild(timespan);

        //creating a div for the message to go into  
        div = document.createElement("div");
        div.className = who;
        //this span will contain the message
        span = document.createElement("span");
        span.className = "msgspan";
        msg = object['msg'].split(' ')

            //creating a variable finalmsg which will be the message in the span
        var finalmsg = '';
        //iterating through the words in the message
        for (i = 0; i < msg.length; i++) {
            // if it finds a HTML <br> tag, append the text to the span as text
            //  and then append the html tag as an actual tag rather than text
            if (msg[i] == '<br>') {
                span.append(finalmsg)
                finalmsg = ''
                span.appendChild(document.createElement("br"))
            } else {
                // if it finds a word, and not a tag, just construct the message
                finalmsg += msg[i] + ' '
            }
        }
        // appending the last bit of message from the for loop
        span.append(finalmsg)

        //span.append(object['msg']);
        // adding the span to the div
        div.appendChild(userspan);
        //div.appendChild(timespan)
        div.appendChild(span);
        // adding the created div to the chat area of the page
        img = document.createElement("img");
        img.src = `../files/pfp/${pfp}`
        img.className = `${where}userpic`
        userspan.appendChild(img)
        $('.messagediv').append(div);
        //scrolling to the bottom of the message div every time a message is sent
        $(".messagediv").scrollTop($(".messagediv")[0].scrollHeight);
    }
    for (j = msgs.length -1; j >= 0; j--) {
        format_msg(msgs[j], pfp[j]);
    }

</script>

<script src="scripts/sidebar.js"></script>
<script src="scripts/client.js"></script>
<script src="scripts/friendadds.js"></script>
<script src="scripts/editchatname.js"></script>
<script src="scripts/uploadfiles-clientside"></script>

</html>