$(document).ready(function () {

    var table = $('#example').DataTable({
        "fixedHeader": true,
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[10, 20, 30, 500, -1], [10, 20, 30, 500, 'ALL']],


        "ajax": {
            "url": "/datatable_qualification_data.php",
            "type": "post",
            "success": function () {
                alert(msg);
            }

        },

        "columnDefs": [
            { "name": 'firstname', "targets": 0 },
            { "name": 'education', "targets": 1, 'orderable': false },
            { "name": 'branch', "targets": 2 },
            { "name": 'year', "targets": 3 },
            { "name": 'marks', "targets": 4 }

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
            url: '/datatable_qualification_data.php',
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




