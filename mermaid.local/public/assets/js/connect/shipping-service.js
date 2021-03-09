function addItem() {
    $("#formItem").attr('action', '/connect/shipping/service/create');
    $("#modalItem").modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thời điểm thông báo không xác định!');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/connect/shipping/service/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/connect/shipping/service/update/' + id);
            $("#item-service_name").val(res.item.service_name);
            $("#item-service_id").val(res.item.service_id);
            $("#item-partner_id").val(res.item.partner_id).trigger('change');
            $("#item-option").val(res.item.option).trigger('change');
            $("#item-support_payment").val(res.item.support_payment).trigger('change');

            $('input[name="status"]').prop('checked', false);
            $('#item-status--' + res.item.status).prop('checked', true).trigger('change');

            $('input[name="is_public"]').prop('checked', false);
            $('#item-is_public--' + res.item.is_public).prop('checked', true).trigger('change');

            $("#modalItem").modal('show');
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
    $("#formItem").attr('action', '/connect/shipping/service/create').trigger('reset');
});
