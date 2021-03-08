$(function(){
    $('.daterange-dateranges').daterangepicker({
        autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(start_date, end_date) {
        $('.daterange-dateranges').val(start_date.format('MM/DD/YYYY') + ' - ' + end_date.format('MM/DD/YYYY'));
    });
});
function detailOrder(id){
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Khách hàng không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/order/detail/' + id,
        success: function (res) {
            $('#modalOrder .modal-content').html(res.html);
            $('#modalOrder').modal('show');
        }
    });

    $('#modalOrder').modal('show');
}
$('#modalOrder').on('hidden.bs.modal', function () {
    $('#modalOrder .modal-content').html('Đang tải.....................');
});

function sendNote() {
    var content = $('#note-content').val();
    if (!content) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', "Note content undefined!");
        return false;
    }

    var id = $('#order_id').val();
    if (!id) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', "Order undefined!");
        return false;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {id: id, content: content},
        type: 'POST',
        url: '/order/note',
        success: function (res) {
            $('#order-notes').append(res.html);
            notify('zmdi zmdi-check zmdi-hc-fw', 'success', 'Success', res.message);
            $('#note-content').val('');
        },
        error: function (xhr, status, error) {
            var res = eval("(" + xhr.responseText + ")");
            notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', res.message);
        }
    });
}
