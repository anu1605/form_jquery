<?php
include("connectConfig.php");

if (isset($_POST['action']) && $_POST['action'] == 'location')
    $post_id = $_POST['post_id'];

$query = $conn->query("SELECT location FROM table_form WHERE post_id= $post_id");
exit($query->fetch_assoc()['location']);
