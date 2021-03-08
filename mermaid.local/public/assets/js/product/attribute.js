function showChildren(id) {
    if (!id) {
        return false;
    }
    var elm = $('.category-item[data-id="' + id + '"]');
    if (elm.hasClass('active')) {
        return false;
    }
    elm.parent().find('.category-item').removeClass('active');
    elm.addClass('active');
    $.ajax({
        type: 'GET',
        data: {feature: 'attribute'},
        url: '/product/category/byParent/' + id,
        success: function (res) {
            $('#catecory--list_level_' + (res.item.level + 1) + ' .catecory--list').html(res.html);
        }
    });

    return false;
}

function showAttribute(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Danh mục sản phẩm không xác định.');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/product/attribute/byCategory/' + id,
        success: function (res) {
            $('#modalView .modal-content').html(res.html);
            $('#formAttribute input[name="category_id"]').val(id);
            $('#modalView').modal('show');
        }
    });
    return false;
}

function showAttributeValue(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thuộc tính sản phẩm không xác định.');
        return false;
    }

    var elm = $('.attribute-item[data-id="' + id + '"]');
    if (elm.hasClass('active')) {
        return false;
    }
    elm.parent().find('.attribute-item').removeClass('active');
    elm.addClass('active');

    $.ajax({
        type: 'GET',
        url: '/product/attribute/values/' + id,
        success: function (res) {
            $('#modalView .modal-content .attribute-value-list').html(res.html);
            $('#modalView').modal('show');
        }
    });
    return false;
}

$('body').on('click', '.attribute-value-item', function() {
    var id = $(this).data('id');
    var elm = $('.attribute-value-item[data-id="' + id + '"]');
    if (elm.hasClass('active')) {
        return false;
    }
    elm.parent().find('.attribute-value-item').removeClass('active');
    elm.addClass('active');
});

function addAttribute() {
    $("#formAttribute").attr('action', '/product/attribute/create').trigger('reset');
    $('#modalAttribute').modal('show');
}

function editAttribute(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thuộc tính sản phẩm không xác định.');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/product/attribute/detail/' + id,
        success: function (res) {
            $("#formAttribute").attr('action', '/product/attribute/update/' + id);
            $('#formAttribute input[name="name"]').val(res.item.name);
            $('#formAttribute input[name="is_required"]').prop('checked', false);
            $('#formAttribute input[value="'+res.item.is_required+'"]').prop('checked', true);
            $('#formAttribute input[name="state"]').prop('checked', false);
            $('#formAttribute input[value="'+res.item.state+'"]').prop('checked', true);
            $('#modalAttribute').modal('show');
        }
    });

    return false;
}

$("#formAttribute").ajaxForm({
    success: function (res) {
        $('#modalAttribute').modal('hide');
        if ($('.attribute-item[data-id="' + res.item.id + '"]').length > 0) {
            $('.attribute-item[data-id="' + res.item.id + '"]').replaceWith(res.html);
        } else {
            $('.attribute-list').append(res.html);
        }
        notify('zmdi zmdi-check zmdi-hc-fw', 'success', 'Thông báo', res.message);
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

function addAttributeValue() {
    $("#formAttributeValue").attr('action', '/product/attribute/value/create').trigger('reset');
    var attributeId = $('.attribute-list .attribute-item.active').data('id');
    if (!attributeId || attributeId <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Thuộc tính sản phẩm không xác định!');
        return false;
    }
    $('#modalAttributeValue input[name="attribute_id"]').val(attributeId);
    $('#modalAttributeValue').modal('show');
}

function editAttributeValue(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Giá trị thuộc tính không xác định.');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/product/attribute/value/detail/' + id,
        success: function (res) {
            $("#formAttributeValue").attr('action', '/product/attribute/value/update/' + id);
            $('#formAttributeValue input[name="value"]').val(res.item.value);
            $('#formAttributeValue input[name="state"]').prop('checked', false);
            $('#formAttributeValue input[value="'+res.item.state+'"]').prop('checked', true);
            $('#modalAttributeValue').modal('show');
        }
    });

    return false;
}

$("#formAttributeValue").ajaxForm({
    success: function (res) {
        $('#modalAttributeValue').modal('hide');
        if ($('.attribute-value-item[data-id="' + res.item.id + '"]').length > 0) {
            $('.attribute-value-item[data-id="' + res.item.id + '"]').replaceWith(res.html);
        } else {
            $('.attribute-value-list').append(res.html);
        }
        notify('zmdi zmdi-check zmdi-hc-fw', 'success', 'Thông báo', res.message);
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

$('#modalView').on('hidden.bs.modal', function () {
    $('#modalView .modal-content').html('');
});

$('#modalAttribute').on('hidden.bs.modal', function () {
    $("#formAttribute").attr('action', '/product/attribute/create').trigger('reset');
});

$('#modalAttributeValue').on('hidden.bs.modal', function () {
    $("#formAttributeValue").attr('action', '/product/attribute/create').trigger('reset');
});
