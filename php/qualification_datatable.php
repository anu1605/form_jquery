<?php
session_start();
include("connectConfig.php");
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $post_request_id = $_SESSION['id'];
    $user_exist = $conn->query("SELECT * FROM table_form WHERE post_id = $post_request_id");
    if (!($user_exist->num_rows > 0))
        header("location: login.php");
} else
    header("location: login.php");

if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
    $post_request_id = $_COOKIE['id'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <link rel="stylesheet" href="/style/datatable.css">


    <script></script>
    <script src="/script/qualification_datatable.js"></script>
</head>

<body>
    <h1>Display Form Information</h1><br>
    <table id="example" class="display" style="width:100%">
        <thead style="background-color: white;">
            <tr>
                <th>firstname</th>
                <th>education</th>
                <th>branch</th>
                <th>year</th>
                <th>marks</th>
                <th>button</th>
            </tr>
        </thead>
        <tbody>


        </tbody>


    </table>
</body>

</html>