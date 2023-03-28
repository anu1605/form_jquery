

<?php
session_start();


if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
    $post_id = $_COOKIE['id'];
}


include("php/connectConfig.php");
$length = $_POST['length'];
$totalRecords;
$query = $conn->query("SELECT * FROM table_form");
$array = [];

while ($row = $query->fetch_assoc()) {
    $totalRecords = $query->num_rows;
    array_push($array, [$row['firstname'], $row['lastname'], $row['email'], $row['gender'], $row['hobbies'], $row['subject'], $row['about_yourself'], $row['image_files'], $row['date'], ' <div class="action_btn"><a onclick="deleteInQualification( ' . $row['post_id'] . ',' . 'table_form' . ')">Delete</a><a onclick="return confirm(' . 'Press OK to edit or Cancel button' . ')" href="/newIndex.php?ID= ' . $row['post_id'] . '">Edit</a></div>']);
}


$json = json_encode(array("data" => $array));
// echo  $json;
// echo '{
//     "data" : [
//     [
//         "wfce",
//         "cercv",
//         "ercfe",
//         "erfv",
//         "erfgv",
//         "erfver",
//         "egv",
//         "erfgv",
//         "gvrth",
//         "rgtgh"
//         ]
//     ]
// }';

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

// if ($params['search']['value'] != "") {
//     $where .= " AND (bk_id like '%" . $params['search']['value'] . "%' OR bk_strtnum like '%" . $params['search']['value'] . "%' OR bk_strt_name like '%" . $params['search']['value'] . "%' OR CONCAT(bk_strtnum,' ',bk_strt_name) like '%" . $params['search']['value'] . "%' OR bk_city like '%" . $params['search']['value'] . "%' OR bk_zip like '%" . $params['search']['value'] . "%' OR bk_dbt_firstname like '%" . $params['search']['value'] . "%' OR bk_dbt_lastname like '%" . $params['search']['value'] . "%' OR CONCAT(bk_dbt_firstname,' ',bk_dbt_lastname) like '%" . $params['search']['value'] . "%' OR bk_cnty like '%" . $params['search']['value'] . "%' OR bk_impr_code like '%" . $params['search']['value'] . "%' OR bk_sq_feet like '%" . $params['search']['value'] . "%' OR bk_yoc like '%" . $params['search']['value'] . "%' OR bk_assess_val like '%" . $params['search']['value'] . "%' OR bk_pur_mo like '%" . $params['search']['value'] . "%' OR bk_pur_yr like '%" . $params['search']['value'] . "%' OR bk_file_mo like '%" . $params['search']['value'] . "%' OR bk_file_dy like '%" . $params['search']['value'] . "%' OR bk_file_yr like '%" . $params['search']['value'] . "%' OR bk_type like '%" . $params['search']['value'] . "%' OR bk_bankcr_type like '%" . $params['search']['value'] . "%' OR CONCAT(bk_file_mo,'/',bk_file_dy,'/',bk_file_yr) like '%" . $params['search']['value'] . "%' OR CONCAT(bk_pur_mo,'/',bk_pur_yr) like '%" . $params['search']['value'] . "%')";
// }
// $data[] = array($row['bk_id'] . '<br><a target="_blank" href="http://www.mapquest.com/maps/map.adp?country=US&addtohistory=&address=' . $row["bk_strtnum"] . ' ' . $row["bk_strt_name"] . '&city=' . $row["bk_city"] . '&state=tx&zipcode=' . $row["bk_zip"] . '&homesubmit=Get+Map, map, toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=600)"><img src="images/mapquest3.gif" border="0" title="www.mapquest.com" height="12" width="12"></a>', "<a href='http://www.whitepage.com/search/FindPerson?extra_listing=mixed&form_mode=opt_b&post_back=1&firstname_begins_with=1&firstname=" . $row["bk_dbt_firstname"] . "&name=" . $row["bk_dbt_lastname"] . "&street=&city_zip=" . $row["bk_Zip"] . "&state_id=TX&localtime=survey' target='_blank'>" . $row["bk_dbt_firstname"] . "&nbsp;" . $row["bk_dbt_lastname"] . "</a><br /><a onclick=goToMarker1('" . $addr . "','" . $row['bk_lat'] . "','" . $row['bk_long'] . "',$(this))>" . $row["bk_strtnum"] . "&nbsp;" . $row["bk_strt_name"] . "</a>", $row['bk_city'] . ', ' . $row['bk_zip'] . '', $row['bk_impr_code'] . '<br>' . $row['bk_sq_feet'] . '', $row['bk_yoc'] . '<br>$' . $row['bk_assess_val'] . '<br>' . $row['bk_pur_mo'] . '/' . $row['bk_pur_yr'] . '', $row['bk_file_mo'] . '/' . $row['bk_file_dy'] . '/' . $row['bk_file_yr'] . '<br>' . $row['bk_type'] . '', "<a style='cursor:pointer' target='_blank' href='http://www.zillow.com/search/Search.htm?addrstrthood=" . $data[$i]["bk_strtnum"] . "" . $data[$i]["bk_strt_name"] . "&citystatezip=tx'><img src='images/zillow_logo44.gif' border='0' title='www.zillow.com'></a><br />" . $row["bk_bankcr_type"] . "");


$json_data = array(
    // "draw"            => intval($params['draw']),
    "recordsTotal"    => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data"            => $array   // total data array

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