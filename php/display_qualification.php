<?php session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/style/display.css">
    <link rel="stylesheet" href="/style/qualification.css">

</head>

<body>

    <h1>Qualification Table</h1>
    <form class="search_container" method="get" action="/php/display_qualification.php">
        <input type="search" name="search" class="search" id="search" value="" placeholder="search">
        <button type="submit" class="search-btn" id="search-btn" name="search-btn">Search</button>
    </form>

    <div style="display:none;" id="loader-symbol" class="loader-symbol qualification_symbol">
        <div style="display:none;" id="loader" class="loader qualification_loader"></div>
        <p style="display:none;" id="loader-text" class="loader-text  qualification_loadText"><label class="wait_msg">Please wait</label></p>
    </div>
    <a class="clear_filter" href="/php/display_qualification.php">Clear Filter</a>

    <div class="qualification_container">
        <table class="qualification_table">
            <tr>
                <?php
                ?>
                <th><a class="sort_anchor" href="/php/display_qualification.php?sort_item=firstname&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index_quali=<?php echo $row_index_quali ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">firstname</a> </th>
                <th>education</th>
                <th>branch</th>
                <th><a class="sort_anchor" href="/php/display_qualification.php?sort_item=year&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index_quali=<?php echo $row_index_quali ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">year</a> </th>
                <th><a class="sort_anchor" href="/php/display_qualification.php?sort_item=marks&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index_quali=<?php echo $row_index_quali ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">marks</a> </th>
                <th>action</th>
            </tr>
            <tr>
                <?php

                include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";
                $displayRowLimit = 10;
                if (isset($_POST['deleteID']) && isset($_POST['table']) && $_POST['deleteID'] !== 'undefined' && $_POST['table'] == 'qualification') {
                    $id = $_POST['deleteID'];
                    $delete = mysqli_query($conn, "DELETE FROM Qualification_table WHERE qualification_records_id= $id");
                }

                if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                    $post_request_id = $_SESSION['id'];
                    $user_exist = $conn->query("SELECT * FROM Qualification_table WHERE post_request_id = $post_request_id");
                    if (!($user_exist->num_rows > 0))
                        header("location: /php/login.php");
                } else
                    header("location: /php/login.php");


                if (isset($_GET['search']) && $_GET['search'] != "")
                    $searched_item = $_GET['search'];
                else $searched_item = '';

                if (isset($_GET['sort_item']) && $_GET['sort_item'] != "")
                    $sort_item = $_GET['sort_item'];
                else $sort_item = 'qualification_records_id';

                if (isset($_GET['switch']) && $_GET['switch'] != "")
                    $switch = $_GET['switch'];
                else $switch = 'ASC';


                $post_request_id = $_SESSION['id'];
                $quali_query = $conn->query("SELECT * FROM Qualification_table  WHERE post_request_id = $post_request_id AND (firstname LIKE '%$searched_item%' OR education LIKE '%$searched_item%' OR branch LIKE '%$searched_item%' OR year LIKE '%$searched_item%' OR marks LIKE '%$searched_item%' OR post_request_id in (SELECT post_request_id FROM Qualification_table))  ORDER BY $sort_item $switch  LIMIT 0,$displayRowLimit");

                $maxrow_quali = $conn->query("SELECT * FROM Qualification_table WHERE post_request_id = $post_request_id AND (firstname LIKE '%$searched_item%' OR education LIKE '%$searched_item%' OR branch LIKE '%$searched_item%' OR year LIKE '%$searched_item%' OR marks LIKE '%$searched_item%' OR post_request_id in (SELECT post_request_id FROM Qualification_table))  ORDER BY $sort_item $switch")->num_rows;
                $lastrow = 0;


                if ($quali_query->num_rows > 0) {
                    while ($quali_row = $quali_query->fetch_assoc()) {
                        $lastrow += 1;
                ?>

                        <td> <?php echo $quali_row['firstname']; ?> </td>
                        <td> <?php echo $quali_row['education']; ?> </td>
                        <td> <?php echo $quali_row['branch']; ?> </td>
                        <td> <?php echo $quali_row['year']; ?> </td>
                        <td> <?php echo $quali_row['marks']; ?> </td>
                        <td class="action_button">
                            <div class="action_btn">
                                <a onclick="deleteInQualification(<?php echo $quali_row['qualification_records_id'] ?>, 'qualification')">Delete</a>
                                <a onclick="return confirm('Press OK to edit or Cancel button')" href="/newIndex.php?ID=<?php echo $quali_row['post_request_id']; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">Edit</a>
                            </div>


                        </td>
            </tr>

    <?php }
                }
    ?>
        </table>
    </div>
    <a id="load_data">Load</a>
    <p class="noData"></p>

    <p style="display:none ; margin:0;" class="max_quali" id="<?php echo $maxrow_quali; ?>"></p>
    <p style="display:none ; margin:0;" class="startID_quali" id="<?php echo $lastrow ?>"></p>
    <p class="searchItem_quali" id="<?php echo $searched_item; ?>"></p>
    <p class="filterItem_quali" id="<?php echo $sort_item; ?>"></p>
    <p class="switch_quali" id="<?php echo $switch; ?>"></p>


    <script src="/script/display.js"></script>
</body>

</html>
<?php

$conn->close();
?>