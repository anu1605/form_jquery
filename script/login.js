

$.ajaxSetup({
    cache: false
});



if ($("input[name=uname]").val().length !== 0 && $("input[name=email]").val().length !== 0) {
    setTimeout(function () {
        window.location.href = '/php/display.php';
    }, 1000);
}

function submit() {
    if (!checkEmail())
        return false;

    $.ajax({
        url: '/php/checkLoginInfo.php',
        type: 'post',
        data: $('#loginPage').serialize() + '&action=' + 'loginPage',
        success: function (msg) {

            if ($.trim(msg) == 'success')
                window.location.href = '/php/display.php';
            if ($.trim(msg).length == 0) {
                $('.session').css('display', 'block');
                $('.session').text("data is incomplete");
            }
            if ($.trim(msg) == 'invalid') {
                $('.session').css('display', 'block');
                $('.session').text("invalid login information");
            }
        }

    });
}

$(document).mousedown(function () {

    $('.session').css('display', 'none');

})

$("input[name=email]").blur(checkEmail)


function checkEmail() {
    if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('input[name=email').val()) && $('input[name=email').val() != '') {
        $('.session').css('display', 'block');
        $('.session').text("invalid email");
        return false;
    }
    return true;
}

window.onLoadCallback = function () {
    gapi.auth2.init({
        client_id: '194269230950-7q4v0g4ishie2bk4mb9u1i5t4mdtn904.apps.googleusercontent.com'
    });
}
// Render Google Sign-in button
function renderButton() {
    gapi.auth2.init({
        client_id: '194269230950-7q4v0g4ishie2bk4mb9u1i5t4mdtn904.apps.googleusercontent.com'
    });
    gapi.signin2.render('gSignIn', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'align-self': 'center',
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
}

// Sign-in success callback
function onSuccess(googleUser) {

    console.log('success');
    // Get the Google profile data (basic)
    var profile = googleUser.getBasicProfile();

    // Retrieve the Google account data
    gapi.client.load('oauth2', 'v2', function () {
        var request = gapi.client.oauth2.userinfo.get({
            'userId': 'me'
        });
        request.execute(function (resp) {
            // Display the user details
            // var profileHTML = '<h3>Welcome ' + resp.given_name + '! <a href="javascript:void(0);" onclick="signOut();">Sign out</a></h3>';
            // profileHTML += '<img src="' + resp.picture + '"/><p><b>Google ID: </b>' + resp.id + '</p><p><b>Name: </b>' + resp.name + '</p><p><b>Email: </b>' + resp.email + '</p><p><b>Gender: </b>' + resp.gender + '</p><p><b>Locale: </b>' + resp.locale + '</p><p><b>Google Profile:</b> <a target="_blank" href="' + resp.link + '">click to view profile</a></p>';
            // document.getElementsByClassName("userContent")[0].innerHTML = profileHTML;

            // document.getElementById("gSignIn").style.display = "none";
            // document.getElementsByClassName("userContent")[0].style.display = "block";

            console.log(resp);
        });
    });
}

// Sign-in failure callback
function onFailure(error) {
    alert(error);
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        document.getElementById("gSignIn").style.display = "block";
    });

    auth2.disconnect
}

// Sign out the user
function signOut() {
    // var auth2 = gapi.auth2.getAuthInstance();
    // auth2.signOut().then(function () {
    //     document.getElementById("gSignIn").style.display = "block";
    // });

    auth2.disconnect();
}