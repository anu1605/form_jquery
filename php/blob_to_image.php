<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include dirname(__FILE__, 2) . "/" . "php/" . "connectConfig.php";

    $query = $conn->query("SELECT * FROM post_images_table where image_id = $id");

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $im = imagecreatefromstring($row['blob_images']);
            $imagepath = dirname(__FILE__, 2) . "/" . "imagesDB/" . date('Y:m:d h:ia') . ".png";


            if ($im !== false) {
                imagepng($im, $imagepath, 0);
                imagedestroy($im);
            } else {
                echo 'An error ocurred';
            }
        }
    } ?>
</body>

</html>