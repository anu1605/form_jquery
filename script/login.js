

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
