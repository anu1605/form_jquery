$(document).ready(function () {

    var table = $('#example').DataTable({
        fixedHeader: {
            header: true
        },
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[10, 20, 30, 500, -1], [10, 20, 30, 500, 'ALL']],


        "ajax": {
            "url": "/test.php",
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
            url: '/test.php',
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



