

<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == "loginPage") {
    extract($_POST);
}


include("connectConfig.php");

if (isset($_POST['action']) && $_POST['action'] == 'loginPage')
    if ((empty($_POST['uname']) || empty($_POST['psw']) || empty($_POST['email']))) {
        exit();
    } else {
        $uname = $_POST['uname'];
        $psw = $_POST['psw'];
        $email =  $_POST['email'];

        $query = $conn->query("SELECT * FROM table_form WHERE firstname = '$uname' AND email = '$email' AND password=MD5('" . $psw . "') ");


        $id = $query->fetch_assoc()['post_id'];


        if ($query->num_rows >= 1) {
            $_SESSION['id'] = $id;
            setcookie('id', $_SESSION['id'], time() + 86400 * 30, '/');
            echo ('success');
        } else
            exit("invalid");
    }




if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    session_unset();
    session_destroy();
    if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
        setcookie('id', '', time() - 3600, '/');
    }
    echo "logout";
}


$conn->close();
?>