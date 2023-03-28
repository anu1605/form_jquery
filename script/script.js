

var emptyInput;
var tableCount = 0;
var isSelected = false;
var alreadyClick = false;
var listLength = 0;
var subjectList = [];
var selectedSbject = [];
var selectedHobbies = [];
var response;
var inuseVal;

// $("#submit").click(func);
$(".subject_input > input").change(checkSubject);

// check already selected subject
for (var i = 0; i < $(".subject_input > input").length; i++) {
  var input = $(".subject_input > input")[i];
  if (input.checked == true) {
    if (selectedSbject.indexOf(input.value) == -1) {
      selectedSbject.push(input.value);
    }

  }
}

// check already selected hobbies
for (var i = 0; i < $("option").length; i++) {
  var input = $("option")[i];
  if (input.selected) {
    if (selectedHobbies.indexOf(input.value) == -1) {
      selectedHobbies.push(input.value);
    }

  }
}



$("#option_container").hide();
$('#hobbies').focus(function () {
  $(this).fadeTo("slow", 0.7);
});
$('#hobbies').blur(function () {
  $(this).fadeTo("fast", 1);
});



$("option").click(function () {
  for (var i = 0; i < $("option").length; i++) {
    var input = $("option")[i];
    if (input.selected == true) {
      if (selectedHobbies.indexOf(input.value) == -1) {
        selectedHobbies.push(input.value);
      }

    }
    else if (selectedHobbies.indexOf(input.value) != -1) selectedHobbies.splice(selectedHobbies.indexOf(input.value), 1)
  }

});

// $(document).ready(function(){

//   $("#submit").click(func);

// });
function submit(id) {
  if (emptyInput != undefined) emptyInput.classList.remove("redBorder");
  // validate firstname
  if ($("#fname").val().trim() == "") {
    $("#fname").focus();
    $("#fname").removeClass('redBorder');
    if (emptyInput != undefined) emptyInput.classList.remove("redBorder");
    emptyInput = $("#fname")[0];
    emptyInput.classList.add("redBorder");
    emptyInput.select();
    emptyInput.scrollIntoView();
    return false;
  }

  // validate lastname
  if ($("#lname")[0].value == "") {
    removeBorder();
    emptyInput = $("#lname")[0];
    emptyInput.classList.add("redBorder");
    emptyInput.select();
    emptyInput.scrollIntoView();
    return;
  }

  // validate email

  if (!validateEmail()) {
    if (emptyInput != undefined && emptyInput != $("#error")[0]) {
      removeBorder();
    }
    emptyInput = $("#email")[0];
    emptyInput.classList.add("redBorder");
    if (emptyInput != '')
      // $('#error').innerHTML = "Enter valid Email";
      email.scrollIntoView();
    return;
  }
  if (inuseVal) {
    alert("Email already in use");
    return;
  }



  // check if gender is selected


  if ($("#male").is(':checked') == false && $("#female").is(':checked') == false) {
    removeBorder();
    emptyInput = $("#male")[0];
    emptyInput.classList.add("redBorder");
    emptyInput.scrollIntoView();
    return;
  }

  // check if hobbies field is empty


  if (selectedHobbies.length == 0) {
    removeBorder();
    emptyInput = $("#hobbies")[0];
    emptyInput.classList.add("redBorder");
    emptyInput.scrollIntoView();

    $("#hobbies_error")[0].innerHTML = "Select Hobbies";
    return;
  } else $("#hobbies_error")[0].innerHTML = "";

  // check if subject field is empty

  if (selectedSbject.length == 0) {
    if (!alreadyClick) addClass();
    $("#option_container")[0].scrollIntoView();
    $("#subect_error")[0].innerHTML = "Select Subject";
    return;
  } else $("#subect_error")[0].innerHTML = "";




  // validate table
  for (var i = 0; i <= tableCount; i++) {
    if ($("#table_body")[0].rows[i] != undefined)
      if (!checkEmptyCell(4, $("#table_body")[0].rows[i]))
        return;
  }

  // image validation
  // if (!fileValidation()) {
  //   return;
  // } else $("#image_error")[0].innerHTML = "";

  // password validation
  if ($("#pwd")[0].value == "") {
    removeBorder();
    emptyInput = $("#pwd")[0];
    emptyInput.select();
    emptyInput.scrollIntoView();
    emptyInput.classList.add("redBorder");
    $("#pwd_message")[0].innerHTML = "enter password";
    return;
  } else if ($(".invalid").length != 0) {
    $("#pwd_message")[0].innerHTML = "enter valid password";
    return;
  }



  if ($("#confirm_pwd")[0].value == "") {
    removeBorder();
    emptyInput = $("#confirm_pwd")[0];
    emptyInput.select();
    emptyInput.scrollIntoView();
    emptyInput.classList.add("redBorder");
    $("#pwd_message")[0].innerHTML = "confirm password";
    return;
  } else if (!confirmPassword()) {
    $("#pwd_message")[0].innerHTML = "confirm password is wrong";
    return;
  } else if ($("#confirm_pwd")[0].value.length != $("#pwd")[0].value.length) {
    removeBorder();
    emptyInput = $("#confirm_pwd")[0];
    emptyInput.select();
    emptyInput.scrollIntoView();
    emptyInput.classList.add("redBorder");
    $("#pwd_message")[0].innerHTML = "confirm password is wrong";
    return;
  } else $("#pwd_message")[0].innerHTML = "";

  // date validation
  if (!validDate()) {
    return;
  }

  // // print output
  // var printContainer = $("#print")[0];
  // printContainer.innerHTML = "";
  // var form = $("#information")[0];
  // var formData = new FormData(form);

  // for (item of formData) {
  //   if (item[0] == "filename") {
  //     var fileInput = $("#myFile");
  //     if (fileInput.files && fileInput.files[0]) {
  //       var reader = new FileReader();
  //       reader.onload = function (e) {
  //         printContainer.innerHTML +=
  //           '<img style = "width : 10rem" src="' + e.target.result + '"/>';
  //       };

  //       reader.readAsDataURL(fileInput.files[0]);
  //     }
  //   } else
  //     printContainer.innerHTML += item[0] + ": " + item[1] + "<br>" + "<br>";
  // }



  $.ajaxSetup({
    cache: false
  });

  $.ajax({
    url: "/php/ajax.php",
    type: "post",
    data: $('#information').serialize() + '&ID=' + id + '&action=' + 'RegistrationofUsers',
    success: function (result) {

      window.location.href = "/php/display.php";
    }
  });
}


var menu_btn = $("#menu")[0];

$("#menu").click(addClass);

function addClass() {
  var container = $("#option_container");
  var arrow = $("#menu")[0];
  container.toggle("slow");
  if (!alreadyClick) {
    arrow.classList.remove("rotate_down");
    arrow.classList.add("rotate_up");
    alreadyClick = true;
  } else {
    arrow.classList.add("rotate_down");
    arrow.classList.remove("rotate_up");
    alreadyClick = false;
  }
}

function checkSubject() {
  if (this.checked == true) {
    $("#subect_error")[0].innerHTML = "";
    if (selectedSbject.indexOf(this.value) == -1)
      selectedSbject.push(this.value);
  } else if (selectedSbject.indexOf(this.value) != -1) selectedSbject.splice(selectedSbject.indexOf(this.value), 1);

}

function addFunc() {
  //Add and delete row
  var table = $("#table_body")[0];
  tableCount = $("#table_body")[0].rows.length;

  //Check for Empty field
  var cellLength = $("#table_body")[0].rows[0].cells.length;
  var x = $("#table_body")[0].rows[tableCount - 1];

  if (!checkEmptyCell(cellLength - 1, x)) {
    return;
  }
  $("#message")[0].innerHTML = "";

  var row = table.insertRow(tableCount);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  cell1.innerHTML =
    '<input class="education_level" type="text" id="education_level" name="education[]" value = "" placeholder="Education qualification">';
  cell2.innerHTML =
    '<input class="field" type="text" id="field" name="field[]" value="" placeholder="Field">';
  cell3.innerHTML =
    '<input class="year" type="number" min="1990" id="year" name="year[]" value="" placeholder="Year">';
  cell4.innerHTML =
    '<input class="marks" type="number" name="marks[]" id="marks" value="" placeholder="Marks Obtained">';
  cell5.innerHTML =
    '<div id="add_and_delete" class="add_and_delete"> <button type="button" onclick="addFunc()" class="add" id="add" name="add" value="+"> + </button> <button type="button" onclick="myDeleteFunction()" class="minus" id="minus" name="minus" value="-"> - </button> </div>';

}

function myDeleteFunction() {
  tableCount = $("#table_body")[0].rows.length;
  if (tableCount - 1 > 0) {
    $("#table_body")[0].deleteRow(tableCount - 1);
    tableCount--;
  }
}

function checkEmptyCell(length, row) {

  for (var i = 0; i < length; i++) {
    var childList = row.cells[i].childNodes;
    var index = 0;
    if (childList.length > 1) index = 1;

    if (childList[index].value == "") {
      if (emptyInput != undefined) emptyInput.classList.remove("redBorder");
      emptyInput = childList[index];
      childList[index].classList.add("redBorder");
      emptyInput.select();
      emptyInput.scrollIntoView();
      $("#message")[0].innerHTML =
        childList[index].placeholder + " is Incomplete";
      return false;
    }
    {
      if (childList[index].id == "year") {
        if (!/^[0-9]{4}$/.test(childList[index].value)) {
          emptyInput = childList[index];
          $("#message")[0].innerHTML = "Enter Valid Year";
          return false;
        }
      }
      if (childList[index].id == "marks") {
        if (!/^[0-9]*$/.test(childList[index].value)) {
          emptyInput = childList[index];
          $("#message")[0].innerHTML = "Enter Valid marks";
          return false;
        }
      }
    }
  }
  $("#message")[0].innerHTML = "";
  return true;
}

$(document).mousedown(removeBorder);

function removeBorder() {
  if (emptyInput != undefined) {
    emptyInput.classList.remove("redBorder");
  }
  $("#pwd_message")[0].innerHTML = "";
  $("#message")[0].innerHTML = "";
  $("#error")[0].innerHTML = "";
  $("#subect_error")[0].innerHTML = "";
  $("#hobbies_error")[0].innerHTML = "";
  // $("#image_error")[0].innerHTML = "";
  $("#date_error")[0].innerHTML = "";
}

var myInput = $("#pwd")[0];
var letter = $("#letter")[0];
var capital = $("#capital")[0];
var number = $("#number")[0];
var length = $("#length")[0];

myInput.onfocus = function () {
  $("#validator").css("display", "block");
};

myInput.onblur = function () {
  $("#validator").hide();
};

$("#pwd").keyup(validator);

function validator() {
  var lowerCaseLetters = /[a-z]/g;

  if (myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  var upperCaseLetters = /[A-Z]/g;
  if (myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  var numbers = /[0-9]/g;
  if (myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  if (myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

var confirm = $("#confirm_pwd")[0];
$("#confirm_pwd").keyup(confirmPassword);
function confirmPassword() {
  if (myInput.value.length != 0) {
    if (confirm.value.length <= myInput.value.length) {
      if (
        confirm.value[confirm.value.length - 1] !=
        myInput.value[confirm.value.length - 1]
      )
        $("#pwd_message")[0].innerHTML =
          "confirm password is wrong";
      else {
        $("#pwd_message")[0].innerHTML = "";
        return true;
      }
    } else
      $("#pwd_message")[0].innerHTML =
        "confirm password is wrong";
  }
  return false;
}


$("#email").blur(function (callback) {
  if ($("#email")[0].value != "")
    validateEmail();
});

function validateEmail() {
  $.ajax({
    url: '/php/checkEmail.php',
    type: 'post',
    data: 'email=' + $("#email").val() + '&action=' + 'checkmail' + '&ID=' + $('.setEditID').attr('id'),
    success: function (msg) {
      if ($.trim(msg) == 'inuse') {
        inuse(true);

      }
      else inuse(false);
    }
  })

  if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($("#email")[0].value)) {
    $("#error")[0].innerHTML = "Enter valid Email";
    return false;
  } else $("#error")[0].innerHTML = "";

  return true;
}

function inuse(boolVal) {
  inuseVal = boolVal;
}



// function fileValidation() {
//   var fileInput = $("#myFile")[0];
//   var imagePara = $("#image_error")[0];

//   if (fileInput.value == "") {
//     imagePara.innerHTML = "upload image file";
//     return false;
//   }

//   var filePath = fileInput.value;
//   var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

//   if (!allowedExtensions.exec(filePath)) {
//     imagePara.innerHTML = "wrong image format";
//     return false;
//   } else imagePara.innerHTML = "";
//   var filesize = fileInput.files[0].size / 1024;
//   if (filesize < 50 || filesize > 200) {
//     alert("Incorrect file size");
//     return false;
//   }
//   return true;
// }

var date = $("#date_input")[0];

function validDate() {
  if (/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/.test(date.value)) {
    $("#date_error")[0].innerHTML = "";
    return true;
  } else {
    removeBorder();
    emptyInput = date;
    emptyInput.classList.add("redBorder");
    $("#date_error")[0].innerHTML = "Enter Valid date";
    emptyInput.select();
    emptyInput.scrollIntoView();
  }


  return false;
}

