$(function () {
    getAdmins()

    $('#liveSearch').on('search', function () {
        getAdmins().search(this.value).draw('search');
    })

    $('#liveSearch').keyup(function () {
        getAdmins().search(this.value).draw();
    });

    $('#allow').click(function () {
        const ids = selectedIds();

        if (ids) {
            update(
                ids,
                {'status': 1},
                'allow',
                'Admin',
                "#FF0000",
                `/ajax/admins/${ids}`
            );
        }
    })

    $('#disallow').click(function () {
        const ids = selectedIds();

        if (ids) {
            update(
                ids,
                {'status': 0},
                'disallow',
                'Admin',
                "#FF0000",
                `ajax/admins/${ids}`
            );
        }
    })
})

function getAdmins() {
    return $('#adminTb').DataTable({
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
            url: 'ajax/admins'
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
            {data: 'name', name: 'name', searchable: true, render: $.fn.dataTable.render.text()},
            {data: 'email', name: 'email', searchable: true, render: $.fn.dataTable.render.text()},
            {data: 'role', name: 'role', searchable: true, render: $.fn.dataTable.render.text()},
        ],
        columnDefs: [
            {"searchable": false}
        ],
    });
}
