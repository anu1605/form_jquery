$(document).ready(function () {
    var table = $('#example').DataTable({
        fixedHeader: {
            header: true
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/test.php",
            "type": "post"
        },

        "info": true,
        "ordering": true,
        "paging": true,
        "filter": true,

        // "lengthChange": true,
        "order": [[2, "desc"], [3, 'asc']],
        "aLengthMenu": [[10, 20, 30, 500, -1], [10, 20, 30, 500, 'ALL']],


    });
})


// $(document).ready(function () {

//     // var PostData = <?php echo json_encode($_POST); ?>;
//     table = $('#example').DataTable({
//         fixedHeader: true,
//         "ajax": {
//             url: '/test.php', // json datasource
//             type: "POST",  // type of method  , by default would be get
//             error: function (msg) {  // error handling code
//                 console.log(msg);
//             },
//         },
//         // "bsort":false,
//         "searching": true,
//         "bProcessing": true,
//         // "language": {
//         //     processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
//         // },
//         "serverSide": true,
//         // "order": [[6, "desc"]],
//         aLengthMenu: [[100, 500, 1000, 2000, 3000], [100, 500, 1000, 2000, 3000]]
//     });
//     // table.on('draw', function () {
//     //     $("#total_rows").text($("#bankruptcy_table_info").text().substring($("#bankruptcy_table_info").text().lastIndexOf("of ") + 3, $("#bankruptcy_table_info").text().lastIndexOf(" entries")));
//     // });
// }); 