function on(btn) {
    $('#overlay').css('display', 'block');
    $(`#${btn.id}-form`).css('display', 'block');
    console.log(btn.id)
}



function off(btn) {
    $('#overlay').css('display', 'none');
    $(`.show-on-overlay`).css('display', 'none');
}

$(function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const room_name = urlParams.get('roomname')

    $('#titleName').text(room_name)

    $('#noteToSend').on('keyup', () => {
        var txt = $('#noteToSend').val()
        console.log(txt)
        $('#charcount').text(`${txt.length}/100`)
        $('#charcountreport').text(`${txt.length}/300`)
    })
})