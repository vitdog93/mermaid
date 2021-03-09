function addItem() {
    $("#formItem").attr('action', '/connect/transport/create');
    $("#modalItem").modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thời điểm thông báo không xác định!');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/connect/transport/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/connect/transport/update/' + id);
            $("#item-name").val(res.item.name);
            $("#item-code").val(res.item.code).trigger('change');
            $("#item-return_fee_percent").val(res.item.return_fee_percent);
            $("#item-max_weight").val(res.item.max_weight);
            $("#item-max_value").val(res.item.max_value);
            for (var i = 0; i < res.item.max_size.length; i++) {
                $("#item-max_size_" + i).val(res.item.max_size[i]);
            }
            $("#item-max_insurance").val(res.item.max_insurance);

            $('input[name="use_insurance"]').prop('checked', false);
            $('#item-use_insurance--' + res.item.use_insurance).prop('checked', true).trigger('change');

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
    $("#formItem").attr('action', '/connect/transport/create').trigger('reset');
});
