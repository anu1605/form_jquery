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
    <link rel="shortcut icon" href="#">
    <title>Document</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
        <button>
            <div class="g_id_signout">Sign Out</div>
        </button>
    </form>
    <p style="display:none;" class="session" id="<?php echo  $_SESSION['id']; ?>"></p>
    <script src="/script/login.js"></script>
</body>


</html>