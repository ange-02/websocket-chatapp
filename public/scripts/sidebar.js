var mychats = document.getElementById('mychats')
var myfriends = document.getElementById('myfriends')
var mycalendar = document.getElementById('mycalendar')
var mysettings = document.getElementById('mysettings')
var reports = document.getElementById('reports')
var sidebar = document.querySelector('.sidebar')

function slide(sidebar, element) {
    if (sidebar.className.indexOf('active') === -1) {
        sidebar.className += ' active';
        $(`#${element.id}div`).removeClass('choice')
        $(`#${element.id}div`).addClass('activechoice')
    } else {
        sidebar.className = 'sidebar'
    }
}

function goBack(btn) {
    let helper = btn.name;
    console.log(helper)
    $(`#${helper}`).removeClass('activechoice');
    $(`#${helper}`).addClass('choice');
    sidebar.className = 'sidebar';
}

mychats.addEventListener('click', () => {
    slide(sidebar, mychats)
});

myfriends.addEventListener('click', () => {
    slide(sidebar, myfriends)
});


mycalendar.addEventListener('click', () => {
    slide(sidebar, mycalendar)
});

mysettings.addEventListener('click', () => {
    slide(sidebar, mysettings)
});

if (reports) {
    reports.addEventListener('click', () => {
        slide(sidebar, reports)
    });
}

/*$(function() {
    $('#reports').click(() => {
        console.log('aa')
        slide('reports')
    })
})*/