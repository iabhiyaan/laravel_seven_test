$(document).ready(function () {
    $("#datatable").DataTable();
    var a = $("#datatable-buttons").DataTable({
        lengthChange: !1,
        buttons: ["copy", "excel", "pdf"],
    });
    $("#key-table").DataTable({ keys: !0 }),
        $("#responsive-datatable").DataTable(),
        $("#selection-datatable").DataTable({ select: { style: "multi" } }),
        a
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
});
