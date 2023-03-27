

<?php
session_start();


if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
    $post_id = $_COOKIE['id'];
}


include("php/connectConfig.php");
$query = $conn->query("SELECT * FROM table_form order by post_id asc");
$array = [];

while ($row = $query->fetch_assoc()) {
    array_push($array, [$row['firstname'], $row['lastname'], $row['email'], $row['gender'], $row['hobbies'], $row['subject'], $row['about_yourself'], $row['image_files'], $row['date'], ' <div class="action_btn"><a onclick="deleteInQualification( ' . $row['post_id'] . ',' . 'table_form' . ')">Delete</a><a onclick="return confirm(' . 'Press OK to edit or Cancel button' . ')" href="/newIndex.php?ID= ' . $row['post_id'] . '">Edit</a></div>']);
}


$json = json_encode(array("data" => $array));
echo  $json;
$conn->close();


?>