$('#exampleModal').on('shown.bs.modal', function () {
    $('.btn').trigger('focus');

})

if ($('.token').attr('id') != '') {
    console.log('show');
    $('.btn').click();
    $('label[for=new_pwd]').css('display', 'block');
    $('label[for=cnfm_pwd]').css('display', 'block');
    $('#new_pwd').css('display', 'block');
    $('#cnfm_pwd').css('display', 'block');
}

$('.btn').css('background-color', 'transparent');
$('.btn').css('color', 'blue');
$('.btn').css('box-shadow', 'none');
$('.btn').css('border', 'none');
$('.btn').css('outline', 'none');
$('label').css('margin-bottom', '0');
$('h5').css('color', '#04AA6D');
$('.btn').css('color', '#04AA6D');

$('.btn-submit').click(function () {
    if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($("#email").val()))) {
        $('#err_msg').text('Enter Valid Email');
        return false;
    }
    else if ($('.token').attr('id') == '') {
        $('#err_msg').text('')
        $.ajax({
            url: "/php/checkLoginInfo.php",
            type: "post",
            data: { 'email': $('#email').val(), 'action': 'forgotpwd' },
            success: function (msg) {
                if ($.trim(msg) == "notRegistered") {
                    $('#err_msg').text("This Email is not Registered");
                }
                else {

                    $.ajax({
                        url: '/php/sendMail.php',
                        type: 'post',
                        data: { 'action': 'mailing', 'email': $('#email').val(), 'token': tokenGenerator() }

                    })


                    $('.modal-body').html("<p style = 'color:#04AA6D;' >A verification link has been sent to your account</p>");

                    $('.close').click(function () {
                        $('.modal-body').html(' <input type="text" name="email" class="email" id="email" value="" placeholder="jhondoe@gmail.com"><p class="err_msg" id="err_msg"></p>');
                    })
                }

            }
        })
    }
    else {
        if (!(/[A-Z])/.test($('.new_pwd')))) {
            $('#err_msg').text('Enter Valid password');
            return;
        }
        if ($('.new_pwd').val().length != $('.cnfm_pwd').val().length) {
            $('#err_msg').text('Confirm password is Wrong');
            return;
        }

        for (var i = 0; i < $('.new_pwd').val().length; i++) {
            if ($('.new_pwd').val()[i] != $('.cnfm_pwd').val()[i]) {
                $('#err_msg').text('Confirm password is Wrong');
                return;
            }
        }

        console.log(check);
    }

}

)

function tokenGenerator() {
    var lower = "abcdefghijklmnopqrstuvwxyz";
    var upper = lower.toUpperCase();
    var numbers = "0123456789";
    var special = "@$%^&*.<>?/#";
    var picker = [lower, upper, numbers, special];
    var used = [];

    var string = "";
    for (i = 0; i < 6; i++) {
        var index = Math.floor(Math.random() * picker.length);
        if (used.length != picker.length) {
            while (used.indexOf(index) != -1) {
                index = Math.floor(Math.random() * picker.length);
            }
            used.push(index);
        }
        else used.splice(0, -1);

        string += picker[index].charAt(Math.floor(Math.random() * picker[index].length));
    }
    console.log(string);

    return string;

}

$(document).mousedown(function () {

})

$.ajaxSetup({
    cache: false
});



if ($("input[name=uname]").val().length !== 0 && $("input[name=email]").val().length !== 0 || !$.isEmptyObject(($('.session').attr('id')))) {
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
    $('#err_msg').text('');
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

