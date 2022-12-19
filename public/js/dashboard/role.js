$(document).ready(function () {

    getRoles();

    $('#liveSearch').on('search', function () {
        getRoles().search(this.value).draw();
    })

    $('#liveSearch').keyup(function () {
        getRoles().search(this.value).draw();
    });
});

function getRoles() {
    return $('#roleTb').DataTable({
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
            url: '/ajax/roles'
        },
        columns: [
            {
                data: 'uuid',
                name: 'uuid',
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" value="${data}"
                    class="flex-check form-check-input" onclick="flexColumn()">`
                }
            },
            {
                data: 'name',
                name: 'name',
                searchable: true,
                render: $.fn.dataTable.render.text()
            },
        ],
        columnDefs: [
            {"searchable": false}
        ],
    });
}
