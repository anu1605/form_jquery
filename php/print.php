
    <?php
    include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";


    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $val) {
            if ($key === 'Hobbies') {
                foreach ($_POST['Hobbies'] as $index)
                    echo   "$key" . "=" . "$index" . "<br>";
            } else if ($key === 'subject') {
                foreach ($_POST['subject'] as $index)
                    echo   "$key" . "=" . "$index" . "<br>";
            } else {
                echo "$key" . " = " . "$val<br>";
            }
        }
    }




    for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {

        $file_name = $_FILES["filename"]["name"][$i];
        $file_size = $_FILES["filename"]["size"][$i];
        $file_tmp = $_FILES["filename"]["tmp_name"][$i];
        $file_type = $_FILES["filename"]["type"][$i];
        $file_path = "upload-images/" . $file_name;

        if (move_uploaded_file($file_tmp, "upload-images/" . $file_name)) {
            echo '<img style = "width : 5rem" src="' . $file_path . '"/><br>';
        } else echo "not succesful";
    }



    ?>
