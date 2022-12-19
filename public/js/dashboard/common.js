$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });

    $('.select2-input').select2({
        allowClear: false,
        placeholder: 'Please choose one.'
    });

    // Check All Event
    $('.table-check #checkAll').on('click', function () {
        $('input:checkbox.flex-check').prop('checked', this.checked);
    });

    $('#update').click(function () {

        const checkedCheckboxes = $('input:checkbox.flex-check:checked');
        const checkedCount = checkedCheckboxes.length;

        if (checkedCount > 0) {

            if (checkedCount > 1) {
                warnEvent('Please select only one item.');
            } else {
                const id = checkedCheckboxes.val();

                if (id) {
                    const path = window.location.pathname;
                    window.location.href = `${path}/${id}/edit`
                }
            }

        } else {
            warnEvent();
        }

    });

    $('#show').click(function () {
        const checkedCheckboxes = $('input:checkbox.flex-check:checked');
        const checkedCount = checkedCheckboxes.length;
        if (checkedCount > 0) {
            if (checkedCount > 1) {
                warnEvent('Please select only one item.');
            } else {
                const id = checkedCheckboxes.val();
                if (id) {
                    const path = window.location.pathname;
                    window.location.href = `${path}/${id}`
                }
            }
        } else {
            warnEvent();
        }
    });

    $('#delete').click(function () {
        const checkedCheckboxes = $('input:checkbox.flex-check:checked');
        const checkedCount = checkedCheckboxes.length;

        if (checkedCount > 0) {

            let ids = [];

            $.each(checkedCheckboxes, function (index) {
                ids[index] = $(this).val();
            });

            const idsStr = ids.join(',')
            const path = window.location.pathname;
            const routeName = path.substring(path.lastIndexOf('/') + 1);

            if (idsStr) {
                fireDeleteEvent(routeName, ids)
            }

        } else {
            warnEvent();
        }
    });

    $('#singleDelete').click(function () {
        const checkedCheckboxes = $('input:checkbox.flex-check:checked');
        const checkedCount = checkedCheckboxes.length;

        if (checkedCount > 0) {
            if (checkedCount > 1) {
                warnEvent('Please select only one item.');
            } else {
                const id = checkedCheckboxes.val();
                if (id) {
                    const path = window.location.pathname;
                    const routeName = path.substring(path.lastIndexOf('/') + 1);
                    fireDeleteEvent(routeName, id)
                }
            }
        } else {
            warnEvent();
        }
    });

});

function warnEvent(text) {
    swal.fire({
        width: 'auto',
        icon: 'warning',
        title: 'Warning!',
        confirmButtonText: 'Close',
        text: text ?? 'Please select at least one item.',
    });
}

function fireDeleteEvent(routeName, ids) {
    swal.fire({
        width: "auto",
        icon: "question",
        title: "Are you sure?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#FF0000",
        html: "<br>Your will not be able to recover this action!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: 'delete',
                url: `/${routeName}/${ids}`,
            }).done(function (response) {
                if (response.success === 1) {
                    if (response.message) {
                        customAlertMsg(`You can't delete this role ${response.message}`)
                    } else {
                        location.reload();
                    }
                } else if (response.success === 2) {
                    customAlertMsg(`You can't delete this data.`)
                } else if (response.success === 3) {
                    customAlertMsg(`You can't delete this package. Please remove the subscriber first.`)
                } else {
                    failAlert(routeName);
                }
            })
        }
    })
}

function customAlertMsg(msg, type = "info") {
    swal.fire({
        icon: type,
        text: msg,
        width: 'auto',
        showCancelButton: false,
        confirmButtonText: "Close",
        title: type.toUpperCase(),
        confirmButtonColor: "#47a1de",
    })
}


function deleteByKey(ele, key) {
    let inputId = $(ele).attr('id');
    swal.fire({
        width: "400px",
        icon: "question",
        title: "Are you sure?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#FF0000",
        html: "<br>Your will not be able to recover this action!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: 'delete',
                url: `/${key}/${inputId}`,
            }).done(function (response) {
                if (response.success === 1) {
                    location.reload();
                } else if (response.success === 2) {
                    failAlert(key, 'You can\'t delete this data.')
                } else {
                    failAlert(key);
                }
            })
        }
    })
}

function failAlert(key, custom = null) {
    let message = "Fail to delete";

    if (key === "roles") {
        message = "Please delete admin first! <br> This role is already used at some admin.";
    }

    if (custom) {
        message = custom
    }

    console.log(custom);

    swal.fire({
        html: message,
        title: "Fail",
        icon: "error",
        showCancelButton: false,
        confirmButtonText: "Close",
    })
}

function flexColumn() {
    const checkboxesCount = $('input:checkbox.flex-check').length;
    const checkedCount = $('input:checkbox.flex-check:checked').length;

    $('.table-check #checkAll').prop('checked', checkedCount > 0);
    $('.table-check #checkAll').prop('indeterminate', checkedCount > 0 && checkedCount < checkboxesCount);
}


function selectedIds() {

    let idsStr = null;

    const checkedCheckboxes = $('input:checkbox.flex-check:checked');
    const checkedCount = checkedCheckboxes.length;

    if (checkedCount > 0) {

        let ids = [];

        $.each(checkedCheckboxes, function (index) {
            ids[index] = $(this).val();
        });

        const str = ids.join(',')

        if (str) {
            idsStr = str;
        }
    } else {
        return warnEvent();
    }

    return idsStr;
}

function update(data, status, msgType, key, color = "#FF0000", url) {
    swal.fire({
        width: "auto",
        icon: "question",
        title: `Are you sure want to ${msgType}?`,
        showCancelButton: true,
        confirmButtonText: msgType.toUpperCase(),
        cancelButtonText: "Cancel",
        confirmButtonColor: color,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: 'put',
                url: `${url}`,
                data: status
            }).done(function (response) {
                if (response.success === true) {
                    location.reload();
                } else {
                    failAlert(key, `You can\'t update the ${key} status.`);
                }
            }).error(function () {
                failAlert(key, `You can\'t update the ${key} status.`);
            });
        }
    })
}

function successEvent(text) {
    swal.fire({
        width: 'auto',
        icon: 'success',
        title: 'Success!',
        confirmButtonText: 'Close',
        text: text ?? 'Success.',
    });
}

function errorEvent(text) {
    swal.fire({
        width: 'auto',
        icon: 'error',
        title: 'Oops!',
        confirmButtonText: 'Close',
        text: text ?? 'Error.',
    });
}
