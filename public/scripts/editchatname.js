$(function() {
    $('#edit-chat-name').click(() => {
        $('#name-editor').toggleClass('hidden')
    })

    $('#closetab').click(() => { // Little X in the top right of the div
        $('#name-editor').toggleClass('hidden')
    })

    $('#confirm-name-change').click(() => {
        var new_name = $('#edit-chat-input').val()
        if (new_name === '') {
            $('#chat-name-notif').text('Cannot be empty!')
        } else {
            const queryString = window.location.search; //getting the parameters from the URL
            const urlParams = new URLSearchParams(queryString);
            const room = urlParams.get('room')
            $.ajax({
                url: '../phpscripts/alter_chat_name.php',
                type: 'post',
                data: {
                    chat_name: new_name,
                    room_ID: room
                },
                success: function(response) {
                    window.location.replace(`http://localhost/School/public/index.php?room=${room}&roomname=${new_name}`)
                }
            })
        }
    })
})