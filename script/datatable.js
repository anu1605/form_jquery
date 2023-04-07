$(document).ready(function () {

    var table = $('#example').DataTable({
        "fixedHeader": true,
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[10, 20, 30, 500, -1], [10, 20, 30, 500, 'ALL']],


        "ajax": {
            "url": "/datatable_data.php",
            "type": "post",

        },

        "columnDefs": [
            { "name": 'firstname', "targets": 0 },
            { "name": 'lastname', "targets": 1 },
            { "name": 'email', "targets": 2 },
            { "name": 'gender', "targets": 3 },
            { "name": 'hobbies', "targets": 4, 'orderable': false },
            { "name": 'subject', "targets": 5, 'orderable': false },
            { "name": 'about_yourself', "targets": 6, 'orderable': false },
            { "name": 'image_files', "targets": 7, 'orderable': false },
            { "name": 'date', "targets": 8 },
            { "name": 'button', "targets": 9, 'orderable': false }

        ],
        "info": true,
        "ordering": true,
        "paging": true,
        "filter": true,
        "sortable": true,

    }
    );


})


function deleteInQualification(element) {

    if ((confirm("Are you sure you want to delete this row"))) {
        $.ajax({
            url: '/datatable_data.php',
            type: "post",
            data: { 'deleteID': element, 'action': 'delete' },
            success: function (result) {
                if ($.trim(result) == "deleted")
                    window.location.href = window.location.href;
            }
        });
    }
    else return false;
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

function getLocation(id) {
    $.ajax({
        url: "/php/getLocation.php",
        type: "post",
        data: { 'post_id': id, 'action': 'location' },
        success: function (location) {
            var loc = $.trim(location).split(',');
            console.log(loc);
            function initMap() {
                const myLatLng = { lat: -25.363, lng: 131.044 };
                const map = new google.maps.Map($("#map"), {
                    zoom: 4,
                    center: myLatLng,
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "Hello World!",
                });
            }

            window.initMap = initMap;
        }
    })
}
