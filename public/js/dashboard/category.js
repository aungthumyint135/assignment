$(document).ready(function () {

    getCategories();

    $('#liveSearch').on('search', function () {
        getCategories().search(this.value).draw();
    })

    $('#liveSearch').keyup(function () {
        getCategories().search(this.value).draw();
    });
});

function getCategories() {
    return $('#categoryTb').DataTable({
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
            url: '/ajax/categories'
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
