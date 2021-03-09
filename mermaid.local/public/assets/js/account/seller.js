function detailSeller(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Khách hàng không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/account/seller/detail/' + id,
        success: function (res) {
            $('#modalSeller .modal-content').html(res.html);
            $('#modalSeller').modal('show');
        }
    });

    $('#modalSeller').modal('show');
}
$('#modalSeller').on('hidden.bs.modal', function () {
    $('#modalSeller .modal-content').html('Đang tải.....................');
});
