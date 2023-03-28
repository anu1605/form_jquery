<?php
include  "php/" . "connectConfig.php";
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $select = $conn->query("SELECT * FROM table_form WHERE post_id=$id");
    $data = $select->fetch_assoc();
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $email = $data['email'];
    $gender = $data['gender'];
    $hobbies =  $data['hobbies'];
    $subject =  $data['subject'];
    $about_you = $data['about_yourself'];
    $quali_select = $conn->query("SELECT * FROM Qualification_table WHERE post_request_id=$id");
    $qualification_rows =  mysqli_num_rows($quali_select);
    $about_yourself = $data['about_yourself'];
    $date = $data['date'];
}
if (isset($_GET['ID'])) {
    $action_path =  '/php/connect.php?ID=' . $_GET['ID'];
} else $action_path = '/php/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/style/indexStyle.css">
        <title>Document</title>
    </head>

<body>
    <div class="information_form">
        <section class="form_heading">
            <h1 class="heading">Form</h1>
        </section>

        <section class="form_content">
            <form id="information" enctype=”multipart/form-data”>
                <label for="fname">Firstname:</label><br>
                <input class="input_text" type="text" id="fname" value="<?php if (!empty($firstname)) echo $firstname; ?>" name="Firstname" placeholder="John"><br>

                <label for="lname">Lastname:</label><br>
                <input class="input_text" type="text" name="Lastname" value="<?php if (!empty($lastname)) echo $lastname; ?>" id="lname" placeholder="doe"> <br>
                <label for="email">Email Id:</label><br>
                <input class="input_text" type="text" value="<?php if (!empty($email)) echo $email; ?>" id="email" name="Email" placeholder="john.doeS@gmail.com"><br>
                <div class="error_message">
                    <p id="error"></p>
                </div>

                <h2 id="gender_selection" class="gender_class ">Select Gender:</h2>
                <input class="radio_button" type="radio" id="male" name="gender" value="male" <?php echo (($gender === "male") ?  'checked' :  ''); ?>>
                <label for="male">Male</label><br>
                <input class="radio_button" type="radio" id="female" name="gender" value="female" <?php echo (($gender === "female") ?  'checked' :  ''); ?>>
                <label for="female">Female</label>

                <h2 id="hobbies_heading">Hobbies</h2>
                <select class="hobbies" name="Hobbies[]" id="hobbies" multiple>
                    <option value="Reading" <?php echo (stripos($hobbies, "Reading") !== false) ? "selected" : ""; ?>>Reading</option>
                    <option value="Sketching" <?php echo (stripos($hobbies, "Sketching") !== false) ? "selected" : ""; ?>>Sketching</option>
                    <option value="Dancing" <?php echo (stripos($hobbies, "Dancing") !== false) ? "selected" : ""; ?>>Dancing</option>
                    <option value="Singing" <?php echo (stripos($hobbies, "Singing") !== false) ? "selected" : ""; ?>>Singing</option>
                    <option value="Painting" <?php echo (stripos($hobbies, "Painting") !== false) ? "selected" : ""; ?>>Painting</option>
                    <option value="None" <?php echo (stripos($hobbies, "None") !== false) ? "selected" : ""; ?>>None</option>
                </select>
                <div>
                    <p id="hobbies_error"></p>
                </div>

                <div class="subject" id="subject">
                    <div id="subject_bar" class="subject_bar">
                        <h2>Subject:</h2>
                        <button type="button" id="menu" name="menu" value="menu">

                            <img class="down_arrow" src="/images/donw arrow.png" alt="">
                        </button>
                    </div>

                    <div id="option_container" class="option_section">
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="maths" value="maths" <?php echo (stripos($subject, "maths") !== false) ? "checked" : ""; ?>>
                            <label for="maths" id="math">Maths</label>
                        </div>
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="biology" value="biology" <?php echo (stripos($subject, "biology") !== false) ? "checked" : ""; ?>>
                            <label for="biology">Biology</label>
                        </div>
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="economics" value="economics" <?php echo (stripos($subject, "economics") !== false) ? "checked" : ""; ?>>
                            <label for="economics">Economics</label>
                        </div>
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="chemistry" value="chemistry" <?php echo (stripos($subject, "chemistry") !== false) ? "checked" : ""; ?>>
                            <label for="chemistry">Chemistry</label>
                        </div>
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="physics" value="physics" <?php echo (stripos($subject, "physics") !== false) ? "checked" : ""; ?>>
                            <label for="physics">Physics</label>
                        </div>
                        <div class="subject_input">
                            <input class="subject_option" type="checkbox" name="subject[]" id="english" value="english" <?php echo (stripos($subject, "english") !== false) ? "checked" : ""; ?>>
                            <label for="english">English</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p id="subect_error"></p>
                </div>

                <div id="qualification_container" class="qualification_container">
                    <h2>Add Qualifications</h2>

                    <div id="qualificatio_table" class="qualificatio_table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="education_level">Education qualification</th>
                                    <th class="field">Field</th>
                                    <th class="year">Year</th>
                                    <th class="marks">Marks Obtained</th>
                                    <th class="action">Action</th>
                                </tr>
                            </thead>

                            <tbody name="table_body[]" id="table_body">

                                <?php if ($quali_select->num_rows > 0) {
                                    $current_index = 0;
                                    while ($table_data = $quali_select->fetch_assoc()) {
                                        $qualification_rows--;
                                ?>
                                        <tr>
                                            <td>
                                                <input class="education_level" type="text" name="education[]" value="<?php echo $table_data['education'] ?>" placeholder="Education qualification">
                                            </td>
                                            <td>
                                                <input class="field" type="text" name="field[]" value="<?php echo $table_data['branch'] ?>" placeholder="Field">
                                            </td>
                                            <td>
                                                <input class="year" type="number" min="1990" name="year[]" value="<?php echo $table_data['year'] ?>" placeholder="Year">
                                            </td>
                                            <td>
                                                <input class="marks" type="number" name="marks[]" value="<?php echo $table_data['marks'] ?>" placeholder="Marks Obtained">
                                            </td>
                                            <td class="button_column">
                                                <div class="add_and_delete">
                                                    <button onclick="addFunc()" type="button" class="add" name="add" value="+">
                                                        +
                                                    </button>
                                                    <?php if ($current_index > 0) echo '<button onclick="myDeleteFunction()" type="button" class="minus" name="minus" value="-">-</button>'; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $current_index++;
                                    }
                                } else { ?>
                                    <tr>

                                        <td>
                                            <input class="education_level" type="text" name="education[]" value="" placeholder="Education qualification">
                                        </td>
                                        <td>
                                            <input class="field" type="text" name="field[]" value="" placeholder="Field">
                                        </td>
                                        <td>
                                            <input class="year" type="number" min="1990" name="year[]" value="" placeholder="Year">
                                        </td>
                                        <td>
                                            <input class="marks" type="number" name="marks[]" value="" placeholder="Marks Obtained">
                                        </td>
                                        <td class="button_column">
                                            <div class="add_and_delete">
                                                <button onclick="addFunc()" type="button" class="add" name="add" value="+">
                                                    +
                                                </button>
                                                <!-- <button onclick="myDeleteFunction()" type="button" class="minus"  name="minus" value="-">-</button> -->
                                    </tr>
                                <?php }
                                ?>
                    </div>
                    </td>

                    </tbody>
                    </table>

                </div>
    </div>
    <div class="message">
        <p id="message"></p>
        <p id="validityMessage"></p>
    </div>
    <div class="about">
        <label for="about_yourself"> Add About Yourself</label>
        <br>
        <textarea name="about_yourself" id="about_yourself" cols="50" rows="5"><?php echo $about_you ?></textarea>
    </div>

    <!-- <div class="upload_image">
        <label for="myFile">Add Image</label>
        <br>
        <input type="file" id="myFile" name="filename[]" multiple required value="" onchange="return fileValidation()">
        <div class="image_message">
            <p id="image_error"></p>
        </div>
    </div> -->
    <br>


    <div class="password">
        <label for="pwd">Password:</label>
        <br>
        <input value="" type="password" id="pwd" name="pwd">
        <br>
        <br>
        <div class="validator" id="validator">
            <h3>Password must contain</h3>
            <p class="invalid" id="letter"> A lowercase letter</p>
            <p class="invalid" id="capital">A capital letter</p>
            <p class="invalid" id="number">A number</p>
            <p class="invalid" id="length">Minimum 8 characters</p>
        </div>

        <label for="pwd">Confirm Password:</label>
        <br>
        <input type="password" id="confirm_pwd" name="confirm_pwd val" value="">
        <div class="pwd_message">
            <p id="pwd_message"></p>
        </div>
    </div>

    <div class="date" id="date">
        <label for="date_input">Date:</label> <br>
        <input type="date" class="" id="date_input" name="date" value="<?php echo $date ?>" placeholder="mm/dd/yyyy">
        <div>
            <p id="date_error"></p>
        </div>
    </div>
    <a href="javascript:void(0);" class="button" id="submit" onclick="submit(<?php echo isset($_GET['ID']) ? $_GET['ID'] : ''; ?>)">Submit</a>
    </form>
    </div>


    </div>
    <script src="/script/script.js"></script>
    </section>
    </div>
    <div id="print"></div>




    <p class="setEditID" id="<?php echo $_GET['ID']; ?>"></p>

</body>

</html>