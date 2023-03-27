$(document).ready(function () {
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/test.php",
            "type": "post"
        },
        // "info": false,
        // "ordering": false,
        // "paging": false,
        // "filter": false,


    });
})