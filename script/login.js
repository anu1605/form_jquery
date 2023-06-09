toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$('#exampleModal').on('shown.bs.modal', function () {
    $('.btn').trigger('focus');

})

if ($('.token').attr('id') != '') {
    $('.btn').click();
    $('label[for=new_pwd]').css('display', 'block');
    $('label[for=cnfm_pwd]').css('display', 'block');
    $('#new_pwd').css('display', 'block');
    $('#cnfm_pwd').css('display', 'block');
    $('#email').css('font-size', '0.7rem');
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
    if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($("#emailRO").val()))) {
        toastr.error("Enter Valid Email");
        return false;
    }
    else if ($('.token').attr('id') == '') {
        $.ajax({
            url: "/php/checkLoginInfo.php",
            type: "post",
            data: { 'email': $('#emailRO').val(), 'action': 'forgotpwd' },
            success: function (msg) {
                if ($.trim(msg) == "notRegistered") {
                    toastr.error("This Email is not Registered");
                }
                else {

                    $.ajax({
                        url: '/php/sendMail.php',
                        type: 'post',
                        data: { 'action': 'mailing', 'email': $('#emailRO').val(), 'token': tokenGenerator() }

                    })


                    $('.modal-body').html("<p style = 'color:#04AA6D;' >A verification link has been sent to your account</p>");

                    $('.close').click(function () {
                        $('.modal-body').html(' <input type="text" name="emailRO" class="emailRO" id="emailRO" value="" placeholder="jhondoe@gmail.com"><p class="err_msg" id="err_msg"></p>');
                    })
                }

            }
        })
    }
    else {


        if (!(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/.test($('#new_pwd').val()))) {
            toastr.error('Enter Valid password');
            return;
        }

        if ($('#new_pwd').val().length != $('#cnfm_pwd').val().length) {
            toastr.error('Confirm password is Wrong');
            return;
        }

        for (var i = 0; i < $('#new_pwd').val().length; i++) {
            if ($('#new_pwd').val()[i] != $('#cnfm_pwd').val()[i]) {
                toastr.error('Confirm password is Wrong');
                return;
            }
        }

        // var email = ;


        $.ajax({
            url: "/php/setNewPass.php",
            type: "post",
            data: { 'pwd': $('#new_pwd').val(), 'action': 'setPass', 'email': $('#emailRO').val() },
            success: function (msg) {
                toastr.success('Success');
                setTimeout(function () {
                    if ($.trim(msg) == 'success')


                        window.location.href = '/php/login.php';
                }, 3000)


            }
        })


    }

}

)

function tokenGenerator() {
    var lower = "abcdefghijklmnopqrstuvwxyz";
    var upper = lower.toUpperCase();
    var numbers = "0123456789";
    var special = "@$%^&*.<>?/";
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



if ($("input[name=email]").val().length !== 0 || !$.isEmptyObject(($('.session').attr('id')))) {
    setTimeout(function () {
        window.location.href = '/php/datatable.php';
    }, 1000);
}

function submit() {
    if ($.isEmptyObject($('#email').val())) {
        toastr.error('email field is empty');
        setTimeout(function () {
            if ($.isEmptyObject($(':password').val()))
                toastr.error('password field is empty');
        }, 200);
        return false;
    }


    else if (!checkEmail())
        return false;


    $.ajax({
        url: '/php/checkLoginInfo.php',
        type: 'post',
        data: { 'action': 'loginPage', "loginBy": "form", 'email': $('#email').val(), 'psw': $('input[name=psw]').val() },
        success: function (msg) {

            if ($.trim(msg) == 'success')
                window.location.href = '/php/datatable.php';
            // if ($.trim(msg) == 'email') {
            //     toastr.error("email field is empty");
            // }
            // if ($.trim(msg) == 'psw') {
            //     toastr.error("password field is empty");
            // }
            // if ($.trim(msg) == 'psw') {
            //     toastr.error("password field is empty");
            // }
            if ($.trim(msg) == 'incorrect') {
                toastr.error("Incorrect Email or Password");
            }
        }

    });
}

// $(document).mousedown(function () {
//     $('#err_msg').text('');
//     $('.session').css('display', 'none');

// })

// $("input[name=email]").blur(checkEmail)



function checkEmail() {
    if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('input[name=email').val()) && $('input[name=email').val() != '') {
        toastr.error("invalid email");
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

