function addItem() {
    $("#formItem").attr('action', '/setting/permission/create');
    $('#modalItem').modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Tính năng không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/setting/permission/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/setting/permission/update/' + id);

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
    $("#formItem").attr('action', '/setting/permission/create').trigger('reset');
});
