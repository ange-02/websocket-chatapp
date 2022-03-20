$(function() {

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


    function appendUserToList(conn) {
        div = document.createElement('div');
        username_span = document.createElement('span');
        div.className = 'user';
        username_span.id = 'username';

        var userimg = document.createElement("img");
        userimg.className = 'userpicside'
        userimg.src = `../files/pfp/${conn[1]}`

        username_span.append(userimg)
        username_span.append(conn[0])
        color = conn[2]
        color = color.replace(/%2C\+/g, ",")
        color = color.split(",")
        username_span.style.color = `rgb(${color[0]}, ${color[1]}, ${color[2]})`
        div.append(username_span)
        document.querySelector('#memberbar').append(div)
    }

    function format(msg, username) {
        var time = moment().format('L H:m');
        return {
            'msg': msg,
            'username': username,
            'time': time,
            'timeStored': moment()
        };
    }


    function store_msg(msg, room) {
        var msgStr = JSON.stringify(msg);
        $.ajax({
            url: '../phpscripts/json-receive.php',
            type: 'post',
            data: {
                message: msgStr,
                room: room,
                user: getCookie("username")
            },
            success: function(response) {
                console.log(`successfully sent ${msgStr}`);
            }
        });
    }


    function make_message(msg, username, who, where, pfp, color) {
        msg = format(msg, username)

        timespan = document.createElement("span")
        timespan.append(msg['time'])
        timespan.id = 'smltxt'

        userspan = document.createElement("p")
        userspan.className = 'msginfo'
        userspan.append(msg["username"])
        userspan.id = where
        color = color.split(",") //making the color string into array
        userspan.style.color = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
        userspan.appendChild(timespan)

        //creating a div for the message to go into
        div = document.createElement("div")
        div.className = who
            //this span will contain the message
        span = document.createElement("span")
        span.className = "msgspan"
            //splitting the words of the message so i can add the line breaks
        msg = msg['msg'].split(' ')
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
            // adding the span to the div
        div.appendChild(userspan)
            //div.appendChild(timespan)
        div.appendChild(span)
            // adding the created div to the chat area of the page
        img = document.createElement("img");
        img.src = `../files/pfp/${pfp}`
        img.className = `${where}userpic`
        userspan.appendChild(img)
        $('.messagediv').append(div);
        //scrolling to the bottom of the message div every time a message is sent
        $(".messagediv").scrollTop($(".messagediv")[0].scrollHeight);
    }




    function sanitise_and_emit(message, pfp) {
        var username = getCookie('username')
            // This regex removes html tags from the user input
        message = addLines(message)
            //this command sends the chat message to the server side from the client side
        if (message.trim().length == 0) {
            return false
        } else {
            socket.emit('chat message', message, username, pfp, getCookie("color"));
            $('#msginput').val(''); //resetting the value of the text area to blank
            return false
        }
    }


    function addLines(message) {
        htmltags = /(<([^>]+)>)/ig
        message = message.replace(htmltags, '')
            //Regular ex pressions replace line breaks with html <br> tags and mulptiple line breaks with 2 <br>'s
        message = message.replace(/(\n){3,}/g, ' <br> <br> ')
        message = message.replace(/(\n)/g, ' <br> ')
        return message
    }






    //establish a connection between client and server
    var socket = io(`http://localhost:3000`);
    //monitoring keypresses on clientside; if enter is pressed, but not shift AND enter, submit form

    // getting the room from the URL
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const room = urlParams.get('room')
    const room_name = urlParams.get('roomname')
    if (urlParams.get('roomname')) {
        const room_name = urlParams.get('roomname')
        $('#titleName').text(room_name);
    } else {
        $('#titleName').text(room);
    }

    $('#file-channel').click(() => {
        window.location.replace(`http://localhost/School/public/fileshare.php?room=${room}&roomname=${room_name}`)
        console.log('aaa')
    })

    socket.emit('username receive', getCookie('username'), getCookie("pfp"), room, getCookie("color"))

    $('#msginput').keypress(function(e) {
        if (e.which == 13 && !e.shiftKey && $('#msginput').val().trim() != '') {
            e.preventDefault(); // prevents page reloading
            message = $('#msginput').val()
            var cleanmsg = addLines(message)
            if (cleanmsg.trim() != '' && cleanmsg.trim() != '<br>' && cleanmsg.trim() != '<br> <br>') {
                store_msg(format(cleanmsg, getCookie('username')), room)
                sanitise_and_emit(message, getCookie('pfp'))
            }
        }
    })


    //when 'send' button is pressed, send a chat message
    // $('#msginput').submit(function(e) {
    //     e.preventDefault(); // prevents page reloading
    //     message = $('#msginput').val()
    //     store_msg(format(message, getCookie('username')), room)
    //     sanitise_and_emit(message, getCookie('pfp'))
    // });

    socket.on('new conn', (conns) => {
        $('div').remove('.user')
        for (i = 0; i < conns.length; i++) {
            appendUserToList(conns[i]);
        }
    })


    //run this function when the server side sends a 'chat message' function
    socket.on('chat message', function(msg, username, pfp, color) {
        color = color.replace(/%2C\+/g, ",")
        make_message(msg, username, 'message', 'leftsmltxt', pfp, color)
    });



    socket.on('my message', function(msg, username, pfp, color) {
        console.log(color)
        color = color.replace(/%2C\+/g, ",") // sanitising the color got from the server
        make_message(msg, username, 'myMessage', 'rightsmltxt', pfp, color);
    });
});