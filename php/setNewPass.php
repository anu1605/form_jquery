<?php

include("connectConfig.php");
if (isset($_POST['action']) && $_POST['action'] == 'setPass') {
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];
}
$query = ("UPDATE table_form SET token = '' , password = MD5('$pwd') WHERE email= '$email' ");

if ($conn->query($query))
    exit('success');
