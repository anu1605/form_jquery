

<?php

use function PHPSTORM_META\type;

session_start();


if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
    $post_id = $_COOKIE['id'];
}


include("php/connectConfig.php");

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $post_id = $_POST['deleteID'];
    $conn->query("DELETE FROM table_form WHERE post_id = $post_id");
    exit("deleted");
}

$length = $_POST['length'];

if (isset($_POST['search']['value']) && $_POST['search']['value'] != '')
    $search_item = $_POST['search']['value'];
$totalRecords = $conn->query("SELECT * FROM table_form WHERE firstname like '%$search_item%' OR lastname like '%$search_item%' OR email like '%$search_item%' OR gender like '%$search_item%' OR hobbies like '%$search_item%' OR subject like '%$search_item%' OR about_yourself like '%$search_item%' OR image_files like '%$search_item%' OR date like '%$search_item%'")->num_rows;


$start = $_POST['start'];
$limit = $_POST['length'];
if ($limit == '-1')
    $limit = $totalRecords;




if (isset($_POST['order']['0']['column'])  && isset($_POST['order']['0']['dir'])) {
    $order =  $_POST['order']['0']['column'];
    $order_item = $_POST['columns'][$order]['name'];
    $direction = $_POST['order']['0']['dir'];
}
$query = $conn->query("SELECT * FROM table_form WHERE (firstname like '%$search_item%' OR lastname like '%$search_item%' OR email like '%$search_item%' OR gender like '%$search_item%' OR hobbies like '%$search_item%' OR subject like '%$search_item%' OR about_yourself like '%$search_item%' OR image_files like '%$search_item%' OR date like '%$search_item%') OR (post_id IN (SELECT post_id FROM table_form)) ORDER BY  $order_item $direction  LIMIT $start , $limit");

$array = [];



while ($row = $query->fetch_assoc()) {
    array_push($array, [$row['firstname'], $row['lastname'], $row['email'], $row['gender'], $row['hobbies'], $row['subject'], $row['about_yourself'], $row['image_files'], $row['date'], ' <div class="action_btn"><a class="delete" onclick="deleteInQualification( ' . $row['post_id'] . ')">Delete</a> <a class="edit"  href="/newIndex.php?ID= ' . $row['post_id'] . '">Edit</a></div>']);
}


$json = json_encode(array("data" => $array));

$columns = array(
    0 => 'firstname',
    1 => 'lastname',
    2 => 'email',
    3 => 'gender',
    4 => 'hobbies',
    5 => 'subject',
    6 => 'about_yourself',
    7 => 'image_files',
    8 => 'password',
    9 => 'date',
    10 => 'edited_at'
);



$json_data = array(
    "draw"            => intval($_POST['draw']),
    "length"          => intval($_POST['length']),
    "start"           => intval($_POST['start']),
    "recordsTotal"    => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data"            => $array

);

echo json_encode(utf8ize($json_data));

function utf8ize($d)
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return mb_convert_encoding($d, "UTF-8", mb_detect_encoding($d));
    }
    return $d;
}

$conn->close();


?>