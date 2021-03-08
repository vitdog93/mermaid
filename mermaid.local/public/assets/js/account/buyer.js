function detailBuyer(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Khách hàng không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/account/buyer/detail/' + id,
        success: function (res) {
            $('#modalBuyer .modal-content').html(res.html);
            $('#modalBuyer').modal('show');
        }
    });

    return false;
}
