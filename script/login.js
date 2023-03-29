

$.ajaxSetup({
    cache: false
});



if ($("input[name=uname]").val().length !== 0 && $("input[name=email]").val().length !== 0) {
    setTimeout(function () {
        window.location.href = '/php/datatable.php';
    }, 1000);
}

function submit() {
    if (!checkEmail())
        return false;

    $.ajax({
        url: '/php/checkLoginInfo.php',
        type: 'post',
        data: $('#loginPage').serialize() + '&action=' + 'loginPage' + "&loginBy=" + "form",
        success: function (msg) {

            if ($.trim(msg) == 'success')
                window.location.href = '/php/datatable.php';
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


const button = $('.g_id_signout');
button.onclick = () => {
    google.accounts.id.disableAutoSelect();
}

function handleCredentialResponse(response) {

    var head = JSON.parse(atob(response.credential.split('.')[0]));
    var body = JSON.parse(atob(response.credential.split('.')[1]));
    if (body.email_verified == true) {
        $.ajax({
            url: "/php/checkLoginInfo.php",
            type: "post",
            data: "action=" + "loginPage" + "&loginBy=" + "glogin" + "&email=" + body.email,
            success: function (msg) {
                if ($.trim(msg) == "success")
                    window.location.href = "/php/datatable.php";
                else
                    window.location.href = "/newIndex.php";
            }
        })
    }

}


window.onload = function () {
    google.accounts.id.initialize({
        client_id: "194269230950-7q4v0g4ishie2bk4mb9u1i5t4mdtn904.apps.googleusercontent.com",
        client_secret: "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",
        callback: handleCredentialResponse,
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
    );
    google.accounts.id.prompt(); // also display the One Tap dialog
}

// FACEBOOK SIGN IN 

