function addSegment() {
    $("#formItem").attr('action', '/notify/segment/create');
    $("#modalItem").modal('show');
}

function editSegment(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thời điểm thông báo không xác định!');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/notify/segment/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/notify/segment/update/' + id);
            $("#item-name").val(res.item.name);

            $('input[name="object_type"]').prop('checked', false);
            $('#type__' + res.item.object_type).prop('checked', true).trigger('change');

            $("#item-object_value").val(res.item.object_value).trigger('change');
            $("#item-shipping").val(res.item.shipping).trigger('change');
            $("#item-cancel_by").val(res.item.cancel_by).trigger('change');
            $("#item-remain").val(res.item.time_remain);
            $("#item-time_pending").val(res.item.time_pending);
            $("#modalItem").modal('show');
        }
    });

    return false;
}

$('#item-object_value option').prop('disabled', true);
$('#item-object_value option.ORDER').prop('disabled', false);
$('input[name="object_type"]').change(function() {
    $('#item-object_value option').prop('disabled', true);
    var type = $(this).val();
    $('#item-object_value option.' + type).prop('disabled', false);

    $('#item-object_value').val("").trigger('change');
    var select2Instance = $('#item-object_value').data('select2');
    var resetOptions = select2Instance.options.options;
    $('#item-object_value').select2('destroy').select2(resetOptions);

    $('#item-shipping').val("").trigger('change');
    $('#item-shipping').parent().hide();
    $('#item-cancel_by').val("").trigger('change');
    $('#item-cancel_by').parent().hide();
    $('#item-remain').val(0).parent().hide();
});

$('#item-object_value').change(function() {
    var state = $(this).val();
    if (state == 'CANCELED') {
        $('#item-shipping').val("").trigger('change');
        $('#item-shipping').parent().show();
        $('#item-cancel_by').val("").trigger('change');
        $('#item-cancel_by').parent().hide();
        $('#item-remain').val(0).parent().hide();
        $('#item-time_pending').val(0).parent().hide();
    } else if (state == 'REJECTED') {
        $('#item-shipping').val("").trigger('change');
        $('#item-shipping').parent().hide();
        $('#item-cancel_by').val("").trigger('change');
        $('#item-cancel_by').parent().show();
        $('#item-remain').val("").parent().hide();
        $('#item-time_pending').val(0).parent().hide();
    } else if (state == 'TIME_REMAIN') {
        $('#item-remain').val(0).parent().show();
        $('#item-time_pending').val(0).parent().hide();
        $('#item-shipping').val("").trigger('change');
        $('#item-shipping').parent().hide();
        $('#item-cancel_by').val("").trigger('change');
        $('#item-cancel_by').parent().hide();
    } else if (state == 'ORDER_PENDING') {
        $('#item-time_pending').val(0).parent().show();
        $('#item-remain').val(0).parent().hide();
        $('#item-shipping').val("").trigger('change');
        $('#item-shipping').parent().hide();
        $('#item-cancel_by').val("").trigger('change');
        $('#item-cancel_by').parent().hide();
    } else {
        $('#item-shipping').val("").trigger('change');
        $('#item-shipping').parent().hide();
        $('#item-cancel_by').val("").trigger('change');
        $('#item-cancel_by').parent().hide();
        $('#item-remain').val(0).parent().hide();
        $('#item-time_pending').val(0).parent().hide();
    }
});

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
    $("#formItem").attr('action', '/notify/segment/create').trigger('reset');
    $('#type__ORDER').prop('checked', true).trigger('change');
});
