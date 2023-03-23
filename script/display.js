

var start;
var limit = 3;
var end = parseInt($('.max').attr('id'));
var inProcess = false;

var start_quali;
var limit_quali = 5;
var end_quali = parseInt($('.max_quali').attr('id'));
console.log(end_quali);
var inProcess_quali = false;
var searchItem = $('.searchItem').attr('id');
var filterItem = $('.filterItem').attr('id');
var toggle = $('.switch').attr('id');

var searchItem_quali = $('.searchItem_quali').attr('id');
var filterItem_quali = $('.filterItem_quali').attr('id');
console.log(filterItem_quali);
var toggle_quali = $('.switch_quali').attr('id');


function submitRow() {

  document.getElementById('submit_rows').submit();
}
$.ajaxSetup({
  cache: false
});

function deleteInQualification(element, table) {
  if (table == 'qualification')
    var url = "/php/display_qualification.php";
  else url = "/php/display.php"
  if ((confirm("Are you sure you want to delete this row"))) {
    $.ajax({
      url: url,
      type: "post",
      data: { 'deleteID': element, 'table': table },
      success: function (result) {
        window.location.href = window.location.href;
      }
    });
  }
  else return false;
}


$(window).on('scroll', function () {
  if (start == undefined)
    start = parseInt($('.startID').attr('id'));
  // console.log(start, limit, end);
  if (!inProcess && start <= end) {
    if (($(window).scrollTop() >= $(document).height() - $(window).height() - 10)) {
      inProcess = true;
      load_more_data();
    }
  }


});



function load_more_data() {
  $.ajax({
    type: 'post',
    url: '/php/dataPages.php',
    dataType: 'html',
    data: { start: start, limit: limit, search: searchItem, filter_item: filterItem, switch: toggle },
    beforeSend: function () {
      $('.loader').css("visibility", "visible");
      $('.loader-text').css("visibility", "visible");
    },
    success: function (response) {
      setTimeout(function () {
        $('.preview_table').append(response);
        inProcess = false;
        start = start + limit;
        if (start > end) {
          $('.loader').hide();
          $('.loader-text').hide();
        }
      }, 1000);

      if ($.trim(response) == "") {
        $('.loader').hide();
        $('.loader-text').hide();
      }
    }
  });
}

$('#load_data').on('click', function () {
  if (start_quali == undefined)
    start_quali = parseInt($('.startID_quali').attr('id'));

  if (!inProcess_quali) {
    load_data_quali();
  }

});



function load_data_quali() {
  $.ajax({
    type: 'post',
    url: '/php/qualification_pages.php',
    dataType: 'html',
    data: { start_quali: start_quali, limit: limit_quali, sort_item: filterItem_quali, search: searchItem_quali, switch: toggle_quali },
    beforeSend: function () {
      $('#load_data').css("visibility", "hidden");
      $('body').css('opacity', '0.8');
      $('#loader-symbol').show();
      $('.loader').show();
      $('.loader-text').show();
    },
    success: function (response) {
      setTimeout(function () {
        $('.qualification_table').append(response);
        $('#load_data').css("visibility", "visible");
        $('body').css('opacity', '1');
        $('.loader').hide();
        $('#loader-symbol').hide();
        $('.loader-text').hide();

        start_quali += limit_quali;
        console.log(start_quali, limit_quali, end_quali);

        if ($.trim(response).length == 0) {
          $('#load_data').css("visibility", "hidden");
          $('.noData').text("No More Data");
        }
      }, 2000);





    }
  });
}

function logout() {
  $.ajax({
    url: '/php/checkLoginInfo.php',
    type: 'post',
    data: 'action=' + 'logout',
    success: function (msg) {
      if ($.trim(msg) == 'logout')
        window.location.href = '/php/login.php';
    }

  })
}



