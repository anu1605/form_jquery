

<?php

if (isset($_POST['action']) && $_POST['action'] == "RegistrationofUsers") {
    extract($_POST);
}


include("connectConfig.php");

// include("checkEmail.php");
// echo $inuse . '<br>';
// if ($inuse)
//     exit();

// foreach ($_POST as $key->$value) {
//     echo ' ' . $key;
// }

// firstname
$array = [];
$firstname = $_POST['Firstname'];
$array['Firstname'] =  $firstname;

// Lastname
$lastname = $_POST['Lastname'];
$array['Lastname'] = $lastname;

// Email
$email = $_POST['Email'];
$array['Email'] = $email;

// password
$pwd = $_POST['pwd'];
$array['pwd'] = $email;

// gender
$gender = $_POST['gender'];
$array['gender'] = $gender;


$hobbies = '';
$subject = '';

// Hobbies
foreach ($_POST['Hobbies'] as $index)
    $hobbies .= "$index" . ",";

$array['Hobbies'] = $hobbies;

// subject
foreach ($_POST['subject'] as $index)
    $subject .= "$index" . ",";

$array['subject'] = $subject;


// time
date_default_timezone_set("Asia/Kolkata");
$time = date('h:ia');





$date = $_POST['date'];

// image file names in string
// $imagePathString = "";
// for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {
//     $file_name = $_FILES["filename"]["name"][$i];
//     $file_tmp = $_FILES["filename"]["tmp_name"][$i];
//     $file_path = "upload-images/" . $file_name;
//     $imagePathString .= $file_name . ",";
// }
// array_push($array, $imagePathString);


// date
$date = $_POST['date'];
if (empty($date) == 'true') {
    $date = date('Y:m:d');
}

array_push($array, $date);


// about yourself
$about = $_POST['about_yourself'];



// check for empty inputs
// foreach ($array as $key => $val) {
//     if (empty($val)) {
//         echo $key . " is empty";
//         return;
//     }
// }

if (isset($_POST['ID']) && $_POST['ID'] !== 'undefined') {
    $get_id = $_POST['ID'];
}


// sql query
if (isset($_POST['ID']) && $_POST['ID'] !== 'undefined') {
    $get_id = $_POST['ID'];
    $sql = "UPDATE table_form SET firstname = '$firstname', lastname= '$lastname',email='$email',gender='$gender',hobbies ='$hobbies',subject='$subject',about_yourself='$about', image_files='$imagePathString',password= MD5('" . $pwd . "'), date='$date'  WHERE post_id= $get_id";
} else
    $sql = "INSERT INTO table_form (firstname, lastname,email,gender,hobbies,subject,about_yourself	, image_files ,password, date ) VALUES ('$firstname', '$lastname','$email', '$gender', '$hobbies', '$subject', '$about', '$imagePathString'  ,MD5('" . $pwd . "'),  '$date')";


if ($conn->query($sql)) {
    echo "tableform successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$id  = $conn->insert_id;


// image
// for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {

//     $file_name = $_FILES["filename"]["name"][$i];
//     $file_size = $_FILES["filename"]["size"][$i];
//     $file_tmp = $_FILES["filename"]["tmp_name"][$i];
//     $file_type = $_FILES["filename"]["type"][$i];
//     $file_path = dirname(__FILE__, 2) . "/" . "upload-images/" . $file_name;

//     if (move_uploaded_file($file_tmp, dirname(__FILE__, 2) . "/" . "upload-images/" . $file_name)) {
//     } else "Image upload was not successful";
// }



echo $_POST['ID'];
if (isset($_POST['ID']) && $_POST['ID'] != 'undefined') {
    $get_id = $_POST['ID'];
    $select = mysqli_query($conn, "DELETE FROM Qualification_table where post_request_id=$get_id");
}


for ($i = 0; $i < count($_POST['education']); $i++) {
    $education = $_POST['education'][$i];
    $field = $_POST['field'][$i];
    $year = $_POST['year'][$i];
    $marks = $_POST['marks'][$i];
    $firstname = $_POST['Firstname'];

    if (isset($_POST['ID']) && $_POST['ID'] != 'undefined') {
        $insert_to_qualification = "INSERT INTO Qualification_table (post_request_id ,firstname, education, branch , year, marks) VALUES('$get_id','$firstname', '$education', '$field', '$year', '$marks')";
    } else {
        $insert_to_qualification = "INSERT INTO Qualification_table (post_request_id , firstname ,education, branch , year, marks) VALUES('$id','$firstname' ,'$education', '$field', '$year', '$marks')";
    }

    if ($conn->query($insert_to_qualification)) {
        echo "qualification successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>