function addUser() {
    $("#formUser").attr('action', '/setting/user/create');
    $('#modalUser').modal('show');
}

function editUser(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Quản trị viên không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/setting/user/detail/' + id,
        success: function (res) {
            $("#formUser").attr('action', '/setting/user/update/' + id);

            $('#item-name').val(res.item.name);
            $('#item-email').val(res.item.email);
            $('#item-avatar').val(res.item.avatar);
            $('#item-role').val(res.item.role).trigger('change');
            $('#item-password').prop('required', false);

            $('#formUser input[name="state"]').prop('checked', false);
            $('#item-state--' + res.item.state).prop('checked', true);
            $('#modalUser').modal('show');
        }
    });

    return false;
}

$("#formUser").ajaxForm({
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

$('#modalUser').on('hidden.bs.modal', function () {
    $("#formUser").attr('action', '/setting/user/create').trigger('reset');
    $('#item-password').prop('required', true);
    $('#item-role').val("").trigger('change');
});
