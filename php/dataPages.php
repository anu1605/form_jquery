<?php
session_start();
include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";
if (isset($_POST['start']) && $_POST['start'] != $conn->query("SELECT max(post_id) FROM table_form")) {
    $id = $_POST['start'];
    $limit = $_POST['limit'];
}


if (isset($_POST['search']) &&  $_POST['search'] != "")
    $searched_item = $_POST['search'];
else $searched_item = '';

if (isset($_POST['filter_item']) &&  $_POST['filter_item'] != "")
    $filter_item = $_POST['filter_item'];
else $filter_item = 'post_id';

if (isset($_POST['switch']) &&  $_POST['switch'] != "")
    $switch = $_POST['switch'];
else $switch = 'ASC';

$post_id = $_SESSION['id'];

$query =  $conn->query("SELECT * FROM table_form  WHERE post_id = $post_id AND (firstname LIKE '%$searched_item%' OR lastname LIKE '%$searched_item%' OR email LIKE '%$searched_item%' OR hobbies LIKE '%$searched_item%' OR subject LIKE '%$searched_item%' or date LIKE '%$searched_item%'or gender LIKE '%$searched_item%' OR post_id in (SELECT post_id FROM table_form)) ORDER BY $filter_item $switch LIMIT $id,$limit");

?>

<?php

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $lastrow = $row['post_id'];
        $fname = $row['firstname'];
?>
        <tr>
            <td> <?php echo $row['firstname']; ?> </td>
            <td> <?php echo $row['lastname']; ?> </td>
            <td> <?php echo $row['email']; ?> </td>
            <td> <?php echo $row['gender']; ?> </td>
            <td> <?php echo $row['hobbies']; ?> </td>
            <td> <?php echo $row['subject']; ?> </td>
            <td> <?php echo $row['about_yourself']; ?> </td>
            <td> <?php echo  $row['image_files']; ?> </td>
            <td> <?php echo $row['date']; ?> </td>
            <td> <?php echo date("d-M-Y h:ia", strtotime($row['edited_at'])); ?> </td>


            <td>
                <div class="action_btn">
                    <a onclick="deleteInQualification(<?php echo $row['post_id'] ?> , 'table_form')">Delete</a>
                    <a onclick="return confirm('Press OK to edit or Cancel button')" href="/newIndex.php?ID=<?php echo $row['post_id']; ?>&rows=<?php echo isset($_POST['rows']) ? $_POST['rows'] : 3; ?>">Edit</a>
                </div>
            </td>

            <script src="/script/display.js"></script>

        </tr>
<?php }
};
$conn->close();
?>