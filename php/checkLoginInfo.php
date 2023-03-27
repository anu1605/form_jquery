

<?php
session_start();
include("connectConfig.php");

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    session_unset();
    session_destroy();
    if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
        setcookie('id', '', time() - 3600, '/');
    }
    echo "logout";
}

if (isset($_POST['action']) && $_POST['action'] == "loginPage") {
    extract($_POST);
}




if (isset($_POST['action']) && $_POST['action'] == 'loginPage') {
    if (isset($_POST['loginBy']) && $_POST['loginBy'] == 'form')
        if ((empty($_POST['uname']) || empty($_POST['psw']) || empty($_POST['email']))) {
            exit();
        } else {
            $uname = $_POST['uname'];
            $psw = $_POST['psw'];
            $email =  $_POST['email'];

            $query = $conn->query("SELECT * FROM table_form WHERE firstname = '$uname' AND email = '$email' AND password=MD5('" . $psw . "') ");
        }

    else if (isset($_POST['loginBy']) && $_POST['loginBy'] == 'glogin') {
        $email =  $_POST['email'];
        $query = $conn->query("SELECT * FROM table_form WHERE  email = '$email'  ");

        if (!($query->num_rows >= 1)) {
            $insert = $conn->query("INSERT INTO table_form (email) VALUES ('$email')");
            $id = $conn->query("SELECT max(post_id) as id FROM table_form")->fetch_assoc()['id'];
            $_SESSION['id'] = $id;
            setcookie('id', $_SESSION['id'], time() + 86400 * 30, '/');
            exit('success');
        }
    }

    $id = $query->fetch_assoc()['post_id'];


    if ($query->num_rows >= 1) {
        $_SESSION['id'] = $id;
        setcookie('id', $_SESSION['id'], time() + 86400 * 30, '/');
        echo ('success');
    } else
        exit("invalid");
}

$conn->close();
?>