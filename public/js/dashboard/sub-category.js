$(document).ready(function () {

    getSubCategories();

    $('#liveSearch').on('search', function () {
        getSubCategories().search(this.value).draw();
    })

    $('#liveSearch').keyup(function () {
        getSubCategories().search(this.value).draw();
    });
});

function getSubCategories() {
    return $('#subCategoryTb').DataTable({
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
            url: '/ajax/sub-categories'
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
                data: 'category',
                name: 'category',
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
