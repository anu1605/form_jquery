<?php
include("connectConfig.php");

session_start();
if (isset($_COOKIE['id']) && !empty($_COOKIE['id']))
    $_SESSION['id'] = $_COOKIE['id'];


if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $post_id = $_SESSION['id'];
    $query = $conn->query("SELECT * FROM table_form WHERE post_id = '$post_id'");
    $info = $query->fetch_assoc();
    $usrname = $info['firstname'];
    $email = $info['email'];
    $passd = $info['password'];
} else $post_id = '';

if (isset($_GET['token']) && $_GET['token'] != '') {
    $token = $_GET['token'];
    $email = $conn->query(("SELECT email FROM table_form WHERE token='$token'"))->fetch_assoc()['email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="google-signin-client_id" content="194269230950-7q4v0g4ishie2bk4mb9u1i5t4mdtn904.apps.googleusercontent.com"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="/style/login.css">
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script> -->
    <link rel="shortcut icon" href="#">
    <title>Document</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<body>
    <form id="loginPage">
        <div class="imgcontainer">
            <img src="/images/img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname">
                Username
            </label>
            <input type="text" placeholder="Enter Username" name="uname" value="<?php echo isset($_SESSION['id']) && !empty($_SESSION['id']) ?  $usrname : ''; ?>" required>

            <label for="email">
                Email
            </label>
            <input type="text" placeholder="Enter Email" name="email" value="<?php echo isset($_SESSION['id']) && !empty($_SESSION['id']) ?  $email : ''; ?>" required>
            <label for="psw">
                Password
            </label>
            <input type="password" placeholder="Enter Password" name="psw" required>



            <a href="javascript:void(0)" class="login" id="login" <?php isset($_SESSION['id']) && !empty($_SESSION['id']) ? 'click' : ''; ?> onclick="submit()">Sign in</a>
            <!-- <a href="javascript:void(0)" class="logout" id="logout"  onclick="submit()">Login</a> -->
            <!-- <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label> -->
        </div>

        <div class="break">
            <hr><label for="">or</label>
            <hr>
        </div>



        <div id="buttonDiv">
        </div>

        <!-- <div class="forgot"><a class="forgot_pass" href="#">forgot password?</a></div> -->
        <!-- Button trigger modal -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            forgot password?
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter your Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="email" id="email" value="<?php echo isset($_GET['token']) ? $email : ''; ?>" <?php echo isset($_GET['token']) ? 'disabled' : ''; ?> placeholder="jhondoe@gmail.com">
                        <label style="display: none;" for="new_pwd">New Password</label>
                        <input style="display: none;" type="password" name="new_pwd" id="new_pwd" value="">
                        <label style="display: none;" for="cnfm_pwd">Confirm Password</label>
                        <input style="display: none;" type="password" name="cnfm_pwd" id="cnfm_pwd" value="">
                        <p class="err_msg" id="err_msg"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-submit">submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FACEBOOK BUTTON -->
        <!-- <div id="spinner" style="
        background: #4267b2;
        border-radius: 5px;
        color: white;
        height: 40px;
        text-align: center;
        width: 250px;">
            Loading
            <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-use-continue-as="true"></div>
        </div> -->
        <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
        </fb:login-button>
        <div id="status">
        </div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v16.0&appId=190632410356156&autoLogAppEvents=1" nonce="5102279v"></script> -->
        <!-- <div class="fb-login-button" data-width="" data-size="" data-button-type="" data-layout="" data-auto-logout-link="false" data-use-continue-as="false"></div> -->
    </form>
    <p style="display:none;" class="session" id="<?php echo isset($_SESSION['id']) ?  $_SESSION['id'] : ''; ?>"></p>
    <p style="display:none;" class="token" id="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>"></p>
    <script src="/script/login.js"></script>
</body>


</html>