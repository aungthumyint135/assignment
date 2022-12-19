$(document).ready(function () {

    getUsers();

    $('#liveSearch').on('search', function () {
        getUsers().search(this.value).draw();
    })

    $('#liveSearch').keyup(function () {
        getUsers().search(this.value).draw();
    });
});

function getUsers() {
    return $('#userTb').DataTable({
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
            url: '/ajax/users'
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
                data: 'email',
                name: 'email',
                searchable: true,
                render: $.fn.dataTable.render.text()
            },
            {
                data: 'status',
                name: 'status',
                searchable: true,
                render: function (data, type, row) {
                    let action= '';
                    console.log(data)
                    if(data === 1) {
                        action += `<a class="btn btn-outline-danger btn-sm" href="/user/${row.id}/deactivate"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Deactivate">
                            Click to Deactivate</a>`
                    }
                    else {
                        action += `<a class="btn btn-outline-success btn-sm " href="/user/${row.id}/activate"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Activate">
                            Click to Activate</i></a>`
                    }

                    return action;
                }
            },
        ],
        columnDefs: [
            {"searchable": false}
        ],
    });
}
