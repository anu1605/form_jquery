

<?php

session_start();
include("php/connectConfig.php");

use function PHPSTORM_META\type;






if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $post_request_id = $_POST['deleteID'];
    $conn->query("DELETE FROM Qualification_table WHERE post_request_id = $post_request_id");
    exit("deleted");
}



$length = $_POST['length'];

if (isset($_POST['search']['value']) && $_POST['search']['value'] != '')
    $search_item = $_POST['search']['value'];


$totalRecords = $conn->query("SELECT * FROM Qualification_table WHERE (firstname like '%$search_item%' OR education like '%$search_item%' OR branch like '%$search_item%' OR year like '%$search_item%' OR marks like '%$search_item%')")->num_rows;


$start = $_POST['start'];
$limit = $_POST['length'];
if ($limit == '-1')
    $limit = $totalRecords;




if (isset($_POST['order']['0']['column'])  && isset($_POST['order']['0']['dir'])) {
    $order =  $_POST['order']['0']['column'];
    $order_item = $_POST['columns'][$order]['name'];
    $direction = $_POST['order']['0']['dir'];
}
$query = $conn->query("SELECT * FROM Qualification_table WHERE (firstname like '%$search_item%' OR education like '%$search_item%' OR branch like '%$search_item%' OR year like '%$search_item%' OR marks like '%$search_item%') ORDER BY  $order_item $direction  LIMIT $start , $limit");

$array = [];



while ($row = $query->fetch_assoc()) {
    array_push($array, [$row['firstname'], $row['education'], $row['branch'], $row['year'], $row['marks'], ' <div class="action_btn"><a class="delete" onclick="deleteInQualification( ' . $row['post_request_id'] . ')">Delete</a> <a class="edit"  href="/newIndex.php?ID= ' . $row['post_request_id'] . '">Edit</a></div>']);
}


$json = json_encode(array("data" => $array));




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