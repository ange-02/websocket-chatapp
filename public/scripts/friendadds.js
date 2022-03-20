var added_users = []

function selected(elem) {
    if (elem.classList.contains('selected')) { //checks if the user is already selected or not
        elem.classList.remove("selected")
        for (i = 0; i < added_users.length; i++) {
            if (added_users[i] == elem.value) {
                added_users.splice(i, 1) // removes user from array
            }
        }
    } else {
        added_users.push(elem.value)
        elem.className += ' selected'
    }
}




$(function() {

    $('#createchat').click(() => {
        $('#friendlist').toggleClass('hidden')
    })

    $('#friendlist').children('.friend').attr('onclick', "selected(this)")

    $('#create').click(() => {
        if (added_users.length > 0) {
            $.ajax({
                url: '../phpscripts/create_chat.php',
                type: 'post',
                data: {
                    users: JSON.stringify(added_users)
                },
                success: function(response) {
                    link = JSON.parse(response)
                    link = link["location"]
                    console.log(link)
                    document.location = link;
                }
            })
        }
    })


    $('#createevent').click(() => {
        $('#participantlist').toggleClass('hidden')
    })

    rooms = document.getElementsByName('room'); //getting all of the rooms populated
    for (i = 0; i < rooms.length; i++) {
        onclick_val = rooms[i].onclick; //getting the onclick attribute of each individual room
        str_onclk = String(onclick_val) //turning it into a string
        str_onclk = str_onclk.replace('function onclick(event) {', '').replace('}', '').replace(/' '/g, '%20')
        search = str_onclk.split("?") //splitting it where the search parameters of the URL begin
        const queryString = search[1]; //the search parameters are in the second half of the split
        const urlParams = new URLSearchParams(queryString);
        rooms[i].value = urlParams.get('room') //getting the room ID only of the room and setting the value of the room as that
    }

    $('#participantlist').children('#friend').attr('onclick', "selected(this)") //changing the onclick function to be selected()

    $('#eventcreate').click(() => {
        if (added_users.length > 0) {
            $.ajax({
                url: '../phpscripts/create_event.php',
                type: 'post',
                data: {
                    'users': JSON.stringify(added_users),
                    'text': $('#eventtxt').val(),
                    'date': $('#eventdate').val()
                },
                success: function(response) {
                    window.location.replace(window.location)
                }
            })
        }
    })

})