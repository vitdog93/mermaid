function addItem() {
    $("#formItem").attr('action', '/setting/role/create');
    $('#modalItem').modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Phân quyền không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/setting/role/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/setting/role/update/' + id);

            $('#item-name').val(res.item.name);
            $('#item-description').val(res.item.description);
            $('#item-slug').val(res.item.slug);

            $('#modalItem').modal('show');
        }
    });

    return false;
}

$("#formItem").ajaxForm({
    success: function (res) {
        location.reload();
    },
    error: function (xhr, status, error) {
        var res = eval("(" + xhr.responseText + ")");
        if (res && res.message) {
            notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', res.message);
        }
    },
    complete: function (xhr) {

    }
});

$('#modalItem').on('hidden.bs.modal', function () {
    $("#formItem").attr('action', '/setting/role/create').trigger('reset');
});

function editPermission(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Phân quyền không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/setting/role/permission/' + id,
        success: function (res) {
            $("#formPermission").attr('action', '/setting/role/permission/' + id);
            $.each(res.permissions, function(k, v) {
                $('#p-' + v).prop('checked', true);
            });
            if ($('#formPermission input[type="checkbox"]').length == $('#formPermission input[type="checkbox"]:checked').length) {
                $('#p-checkall').prop('checked', true);
            }

            $('#modalPermission').modal('show');
        }
    });
}

$('#p-checkall').change(function() {
    $("#formPermission input").prop('checked', ($('#p-checkall:checked').length == 1));
});

$("#formPermission").ajaxForm({
    success: function (res) {
        $('#modalPermission').modal('hide');
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'success', 'Thông báo', res.message);
    },
    error: function (xhr, status, error) {
        var res = eval("(" + xhr.responseText + ")");
        if (res && res.message) {
            notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', res.message);
        }
    },
    complete: function (xhr) {

    }
});

$('#modalPermission').on('hidden.bs.modal', function () {
    $("#formPermission").trigger('reset');
    $('#modalPermission input[type="checkbox"]').prop('checked', false);
});
