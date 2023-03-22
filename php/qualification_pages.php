<?php
session_start();
include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";
if (isset($_POST['start_quali']) && $_POST['start_quali'] != $conn->query("SELECT max(post_request_id) FROM Qualification_table")) {
    $id = $_POST['start_quali'];
    $limit = $_POST['limit'];
}


if (isset($_POST['search']) && $_POST['search'] != "")
    $searched_item = $_POST['search'];
else $searched_item = '';

if (isset($_POST['sort_item']) && $_POST['sort_item'] != "")
    $sort_item = $_POST['sort_item'];
else $sort_item = 'qualification_records_id';

if (isset($_POST['switch']) && $_POST['switch'] != "")
    $switch = $_POST['switch'];
else $switch = 'ASC';

$post_request_id = $_SESSION['id'];

$quali_query = $conn->query("SELECT * FROM Qualification_table WHERE post_request_id = $post_request_id AND (firstname LIKE '%$searched_item%' OR education LIKE '%$searched_item%' OR branch LIKE '%$searched_item%' OR year LIKE '%$searched_item%' OR marks LIKE '%$searched_item%' OR post_request_id in (SELECT post_request_id FROM Qualification_table))  ORDER BY $sort_item $switch LIMIT $id, $limit");

?>

<?php

if ($quali_query->num_rows > 0) {
    while ($quali_row = $quali_query->fetch_assoc()) {
?>
        <tr>
            <td> <?php echo $quali_row['firstname']; ?> </td>
            <td> <?php echo $quali_row['education']; ?> </td>
            <td> <?php echo $quali_row['branch']; ?> </td>
            <td> <?php echo $quali_row['year']; ?> </td>
            <td> <?php echo $quali_row['marks']; ?> </td>
            <td class="action_button">
                <div class="action_btn">
                    <a onclick="deleteInQualification(<?php echo $quali_row['qualification_records_id'] ?>, 'qualification')">Delete</a>
                    <a onclick="return confirm('Press OK to edit or Cancel button')" href="/newIndex.php?ID=<?php echo $quali_row['post_request_id']; ?>&rows=<?php echo isset($_POST['rows']) ? $_POST['rows'] : 3; ?>">Edit</a>
                </div>


            </td>

        </tr>
<?php }
};
$conn->close();
?>