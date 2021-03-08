function addItem() {
    $("#formItem").attr('action', '/notify/create');
    $("#modalItem").modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thời điểm thông báo không xác định!');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/notify/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/notify/update/' + id);
            $("#item-name").val(res.item.name);
            $("#item-title").val(res.item.title);
            $("#item-content").val(res.item.content);
            $("#item-template_id").val(res.item.template_id).trigger('change');

            $('input[name="type"]').prop('checked', false);
            $('#type__' + res.item.type).prop('checked', true).trigger('change');

            $('input[name="send_type"]').prop('checked', false);
            $('#send_type-' + res.item.send_type).prop('checked', true);

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
    $("#formItem").attr('action', '/notify/create').trigger('reset');
    $('#item-template_id').parent().hide();
});

$('input[name="type"]').change(function() {
    var type = $(this).val();
    if (type == 'EMAIL') {
        $('#item-template_id').parent().show();
    } else {
        $('#item-template_id').parent().hide();
    }
});
