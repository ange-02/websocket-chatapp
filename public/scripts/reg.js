$(function() {
    $('#username').on('keyup', () => {
        //this function determines whether the username contains any forbidden characters (apostrophes/speech marks)
        input = document.getElementById('username')
            // I create a regular expression to look for apostrophes and commas in the username box
        forbidden = /(')|(")/g;
        htmltags = /(<([^>]+)>)/ig
        if (forbidden.test(input.value) || htmltags.test(input.value)) {
            // if the regular expression finds these charactes, it will not allow the user to procees with signing up
            input.setCustomValidity('This field contains forbidden characters!');
        } else {
            input.setCustomValidity('');
        }
    })

    $('#submitbutton').click(() => {
        for (i = 1; i < 5; i++) {
            forbidden = /(')|(")/g;
            htmltags = /(<([^>]+)>)/ig
            class_taken = document.getElementById(`class${i}`)
            if (forbidden.test(class_taken.value) || htmltags.test(class_taken.value)) {
                class_taken.setCustomValidity('This field contains forbidden characters!');
            } else {
                class_taken.setCustomValidity('');
            }
        }
    })


    $('#passconfirm').on('keyup', () => {
        // this function check whether the confirm password field matches the password field
        var confirm = document.getElementById('passconfirm')
        var pass = $('#password')
        var passconf = $('#passconfirm')
        if (passconf.val() != pass.val()) {
            // if they are not matching, user will not be allowed to sign up
            confirm.setCustomValidity('Password Must be Matching.');
            // making the border red to show the user there is a problem
            passconf.css("border-color", "red")
                // telling the user their passwords don't match
            $('#passptag').text('passwords don\'t match!')
        } else {
            confirm.setCustomValidity('');
            // if they match, the box will turn green to show it's ok
            passconf.css("border-color", "limegreen")
            $('#passptag').text('')
        }
    });

    $('#password').on('keyup', () => {
        //this function chacks how strong the password is
        var passbox = $('#password')
            // this is a regular expression which checks whether the password contains upper-case characters, lower-case characters, numbers, symbols and has at least 8 characters
        var goodRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
        // medium regex only checks for uppercase and lowercase OR lowercase and numbers OR uppercase and numbers and is at least 6 characters long
        var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
        var pastrength = $('#pastrength')
        if (goodRegex.test(passbox.val()) && passbox.val()) {
            // if the 'strong' regex matches the password inputted, the box will have a green border and it will tell the user
            passbox.css("border-color", "limegreen");
            pastrength.text("Strong password :)");
            pastrength.css("color", "limegreen");
            document.getElementById('password').setCustomValidity('')
        } else if (mediumRegex.test(passbox.val()) && passbox.val()) {
            // if the 'medium' regex matches the password inputted, the box will have a yellow border and it will tell the user
            passbox.css("border-color", "yellow");
            pastrength.text("Good password :|");
            pastrength.css("color", "yellow");
            document.getElementById('password').setCustomValidity('')

        } else {
            if (passbox.val()) {
                // if the password does not match any regex, it is a weak password and the box will be red and will tell the user
                passbox.css("border-color", "red");
                pastrength.text("weak password :(");
                pastrength.css("color", "pink");
                document.getElementById('password').setCustomValidity('Password too weak! Consider making it at least 6 characters long, using numbers, capital letters, and symbols')
            }
        }
    })

});