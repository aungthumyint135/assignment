$(document).ready(function () {

    getItems();

    $('#liveSearch').on('search', function () {
        getItems().search(this.value).draw();
    })

    $('#liveSearch').keyup(function () {
        getItems().search(this.value).draw();
    });
});

function getItems() {
    return $('#itemTb').DataTable({
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
            url: '/ajax/items'
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
            {
                data: 'subCategory',
                name: 'subCategory',
                searchable: true,
                render: $.fn.dataTable.render.text()
            },
            {
                data: 'desc',
                name: 'desc',
                searchable: true,
                render: $.fn.dataTable.render.text()
            },
        ],
        columnDefs: [
            {"searchable": false}
        ],
    });
}
