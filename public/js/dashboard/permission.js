$(document).ready(function () {

    getPermissions();

    $('#liveSearch').on('search', function () {
        getPermissions().search(this.value).draw();
    });

    $('#liveSearch').keyup(function () {
        getPermissions().search(this.value).draw();
    });
});

function getPermissions() {
    return $('#permissionTb').DataTable({
        bSort: false,
        ordering: false,
        processing: true,
        serverSide: true,
        deferRender: true,
        targets: 'no-sort',
        destroy: true,
        responsive: false,
        pagingType: 'full',
        ajax: {
            type: 'post',
            url: '/ajax/permissions'
        },
        columns: [
            {data: 'name', name: 'name', searchable: true, render: $.fn.dataTable.render.text()}
        ],
        "columnDefs": [
            {"searchable": false}
        ],
    });
}
