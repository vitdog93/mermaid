function addItem() {
    $("#formProduct").attr('action','/product/create');
    $('#modalForm').modal('show');
    return false;
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', "Sản phẩm không xác định.");
        return false;
    }
    $.ajax({
        type:'GET',
        url:'/product/detail' + id,
        success: function (res){
            $('#productCode').val('res.item.code');
            $('#productName').val('res.item.name');
            $('#productDescription').val('res.item.description');
            $('#productQuantity').val('res.item.quantity');
            $("#formProduct").attr('action','/product/update');
            $('#modalForm').modal('show');
        }
    });
    return false;
}
function viewItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', "Sản phẩm không xác định.");
        return false;
    }
    $.ajax({
        type: 'GET',
        url: '/product/detail/' + id,
        success: function (res) {
            $('#modalItem .modal-content').html(res.html);
            $('#modalItem').modal('show');
        },
        error: function (xhr, status, error) {
            var res = eval("(" + xhr.responseText + ")");
            if (res && res.message) {
                notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', res.message);
            }
        },
    });
    $('#modalItem').modal('show');
}

$('#modalItem').on('hidden.bs.modal', function () {
    $('#modalItem .modal-content').html('Đang tải.....................');
});
$('#modalForm').on('hidden.bs.modal', function () {
    $('#productCode').val('');
    $('#productName').val('');
    $('#productDescription').val('');
    $('#productQuantity').val('');
});

function updateState(id, state, version) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', "Sản phẩm không xác định.");
        return false;
    }

    if (!version || version <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', "Phiên bản cập nhật không xác định.");
        return false;
    }

    if (!state) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', "Trạng thái cập nhật không xác định.");
        return false;
    }

    swal({
        title: 'Bạn có chắc?',
        text: 'Trạng thái sản phẩm sẽ được cập nhật sau khi bạn xác nhận.',
        type: 'question',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-danger',
        confirmButtonText: 'Xác nhận!',
        cancelButtonText: 'Hủy',
        cancelButtonClass: 'btn btn-secondary'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                url: '/product/updateState/' + id,
                data: {
                    state: state,
                    version: version
                },
                success: function (res) {
                    $('#btn__approve').remove();
                    $('#btn__reject').remove();
                    notify('zmdi zmdi-check zmdi-hc-fw', 'success', 'Thông báo', res.message);
                },
                error: function (xhr, status, error) {
                    var res = eval("(" + xhr.responseText + ")");
                    if (res && res.message) {
                        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', res.message);
                    }
                },
            });
        }
    });
    return false;
}
