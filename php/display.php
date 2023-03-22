<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/style/display.css">
</head>

<body>
    <br>


    <form class="search_container" method="get" action="/php/display.php">
        <h1>Display Form Information</h1><br>
        <input type="search" name="search" class="search" id="search" value="" placeholder="search">
        <button type="submit" class="search-btn" id="search-btn" name="search-btn">Search</button>
    </form>
    <a class="clear_filter" href="/php/display.php">Clear Filter</a>
    <a class="qualification_anchor" href="/php/display_qualification.php">Click to see Qualifications Details</a>
    <a href="javascript:void(0);" class="logout" onclick="logout()">Logout</a>
    <div class="preview">
        <?php
        include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";
        extract($_POST);


        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $post_id = $_SESSION['id'];
            $user_exist = $conn->query("SELECT * FROM table_form WHERE post_id = $post_id");
            if (!($user_exist->num_rows > 0)) {
                session_unset();
                session_destroy();
                if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
                    setcookie('id', '', time() - 3600, '/');
                }
                header("location: /php/login.php");
            }
        } else
            header("location: /php/login.php");



        ?>



        <table class="preview_table">
            <tr>
                <th class="main_data"> <a class="sort_anchor" href="/php/display.php?filter_item=firstname&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index=<?php echo $row_index ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">firstname</a> </th>
                <th class="main_data"><a class="sort_anchor" href="/php/display.php?filter_item=lastname&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index=<?php echo $row_index ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">lastname</a></th>
                <th class="main_data"><a class="sort_anchor" href="/php/display.php?filter_item=email&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == 'DESC' ? 'ASC' : 'DESC' ?>&row_index=<?php echo $row_index ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">email</a></th>
                <th class="main_data">gender</th>
                <th class="main_data">hobbies</th>
                <th class="main_data">subject</th>
                <th class="main_data">about_yourself</th>
                <th class="main_data">image_files</th>
                <th class="main_data"><a class="sort_anchor" href="/php/display.php?filter_item=date&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == "DESC" ? 'ASC' : "DESC" ?>&row_index=<?php echo $row_index ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">date</a></th>
                <th class="main_data"><a class="sort_anchor" href="/php/display.php?filter_item=edited_at&switch=<?php echo isset($_GET['switch']) && $_GET['switch'] == "DESC" ? 'ASC' : "DESC" ?>&row_index=<?php echo $row_index ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ""; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">edited_at</a></th>
                <!-- <th class="main_data">Uploaded_Images</th> -->
                <th class="main_data">Action</th>
            </tr>

            <tr>
                <?php
                $displayRowLimit = 10;

                if (isset($_POST['deleteID']) && isset($_POST['table']) && $_POST['deleteID'] !== 'undefined' && $_POST['table'] === 'table_form') {
                    $deleteID = $_POST['deleteID'];
                    $delete_main = mysqli_query($conn, "DELETE FROM table_form WHERE post_id = $deleteID");
                }

                if (isset($_GET['search']) &&  $_GET['search'] != "")
                    $searched_item = $_GET['search'];
                else $searched_item = '';

                if (isset($_GET['filter_item']) &&  $_GET['filter_item'] != "")
                    $filter_item = $_GET['filter_item'];
                else $filter_item = 'post_id';



                if (isset($_GET['switch']) &&  $_GET['switch'] != "")
                    $switch = $_GET['switch'];
                else $switch = 'ASC';
                $lastrow = 0;

                $post_id = $_SESSION['id'];
                $maxrows = $conn->query("SELECT * FROM table_form  WHERE post_id = $post_id AND (firstname LIKE '%$searched_item%' OR lastname LIKE '%$searched_item%' OR email LIKE '%$searched_item%' OR hobbies LIKE '%$searched_item%' OR subject LIKE '%$searched_item%' or date LIKE '%$searched_item%'or gender LIKE '%$searched_item%' OR post_id in (SELECT post_id FROM table_form)) ORDER BY $filter_item $switch")->num_rows - 1;
                $query = $conn->query("SELECT * FROM table_form  WHERE post_id = $post_id AND (firstname LIKE '%$searched_item%' OR lastname LIKE '%$searched_item%' OR email LIKE '%$searched_item%' OR hobbies LIKE '%$searched_item%' OR subject LIKE '%$searched_item%' or date LIKE '%$searched_item%'or gender LIKE '%$searched_item%' OR post_id in (SELECT post_id FROM table_form)) ORDER BY $filter_item $switch LIMIT 0,$displayRowLimit");

                // if (!($query->num_rows > 0)) {
                //     session_unset();
                //     session_destroy();
                //     if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
                //         setcookie('id', '', time() - 3600, '/');
                //     }
                //     header("location:/newIndex.php?user=loggedout");
                // }



                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $lastrow += 1;
                ?>
                        <td> <?php echo $row['firstname']; ?> </td>
                        <td> <?php echo $row['lastname']; ?> </td>
                        <td> <?php echo $row['email']; ?> </td>
                        <td> <?php echo $row['gender']; ?> </td>
                        <td> <?php echo $row['hobbies']; ?> </td>
                        <td> <?php echo $row['subject']; ?> </td>
                        <td> <?php echo $row['about_yourself']; ?> </td>
                        <td> <?php echo $row['image_files']; ?> </td>
                        <td> <?php echo $row['date']; ?> </td>
                        <td> <?php echo date("d-M-Y h:ia", strtotime($row['edited_at'])); ?> </td>


                        <td>
                            <div class="action_btn">
                                <a onclick="deleteInQualification(<?php echo $row['post_id'] ?> , 'table_form')">Delete</a>
                                <a onclick="return confirm('Press OK to edit or Cancel button')" href="/newIndex.php?ID=<?php echo $row['post_id']; ?>&rows=<?php echo isset($_GET['rows']) ? $_GET['rows'] : 3; ?>">Edit</a>
                            </div>
                        </td>

            </tr>

    <?php }
                }
    ?>

        </table>
        <div style="visibility: hidden;" class="loader-symbol">
            <div style="visibility: hidden;" class="loader">
            </div>
            <p style="visibility: hidden;" class="loader-text">Please wait</p>
        </div>

        <p class="max" id="<?php echo $maxrows; ?>"></p>
        <p style="display:none" class="startID" id="<?php echo $lastrow ?>"></p>
        <p class="searchItem" id="<?php echo $searched_item ?>"></p>
        <p class="filterItem" id="<?php echo $filter_item ?>"></p>
        <p class="switch" id="<?php echo $switch ?>"></p>


    </div>


    <?php
    $conn->close();
    ?>
    <script src="/script/display.js"></script>
</body>

</html>