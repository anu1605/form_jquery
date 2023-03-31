<?php

include("connectConfig.php");



if (isset($_POST['action']) && $_POST['action'] == 'mailing') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $message = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <style>
        a.setPwd {
            font-size: 1rem;
            padding: 0.5rem 2rem;
            font-weight: 600;
            text-decoration: none;
            background-color: #eb4747;
            opacity: 0.8;
            color: white;
        }
    </style>
    <script>

    </script>
</head>

<body>
    <br>
    <p>Please click this link to reset your password</p>

    <a href="http://localhost:3000/php/login.php?token=' . $token . ' " class="setPwd" id="setPwd">verify</a>
    <br>
</body>

</html>

    ';

    echo $message;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <webmaster@example.com>' . "\r\n";

    $query = $conn->query("UPDATE table_form SET token = '$token' WHERE email = '$email'");
    mail("$email", "verification",  $message, $headers);
}
