

<?php
include("connectConfig.php");

if (isset($_POST['action']) &&  $_POST['action'] == 'checkmail') {
    $email = $_POST['email'];
    $query = $conn->query("SELECT * FROM table_form WHERE email = '$email' ");

    if ($query->num_rows > 0) {
        exit('inuse');
    }
}

?>