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

function addCategory(parentId, level) {
    if (level > 1) {
        if (!parentId || parentId <= 0) {
            parentId = $('#catecory--list_level_'+(level-1)+' .category-item.active').data('id');
        }

        if (!parentId || parentId <= 0) {
            notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Danh mục cha không xác định!');
            return false;
        }
    }

    var parentName = $('.category-item[data-id="' + parentId + '"] .category-contents').text();
    if (!parentName) {
        parentName = "Không có";
    }
    $('#parent-category').html('<b>'+parentName+'</b>');
    $('#item-parent_id').val(parentId);
    $("#formCategory").attr('action', '/product/category/create');
    $('#modalCategory').modal('show');
    return false;
}

function editCategory(id) {
    if (!id || id <= 0) {
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/product/category/detail/' + id,
        success: function (res) {
            $("#formCategory").attr('action', '/product/category/update/' + id);
            var parentName = $('.category-item[data-id="' + res.item.parent_id + '"] .category-contents').text();
            if (!parentName) {
                parentName = "Không có";
            }
            $('#parent-category').html('<b>'+parentName+'</b>');

            $('#item-name').val(res.item.name);
            $('#item-avatar_url').val(res.item.avatar_url);

            $('#formCategory input[name="state"]').prop('checked', false);
            $('#item-state--' + res.item.state).prop('checked', true);
            $('#modalCategory').modal('show');
        }
    });

    return false;
}

$("#formCategory").ajaxForm({
    success: function (res) {
        $('#modalCategory').modal('hide');
        if ($('.category-item[data-id="' + res.item.id + '"]').length > 0) {
            $('.category-item[data-id="' + res.item.id + '"]').replaceWith(res.html);
        } else {
            $('#catecory--list_level_' + res.item.level + ' .catecory--list').append(res.html);
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

$('#modalCategory').on('hidden.bs.modal', function () {
    $("#formCategory").attr('action', '/product/category/create').trigger('reset');
});

$('.category__filter').select2({
    ajax: {
        url: "/product/category/filter",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: data.pagination
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    placeholder: 'Tìm kiếm danh mục...',
    minimumInputLength: 0,
    templateResult: formatRepoCategory,
    templateSelection: formatRepoCategorySelection
});

function formatRepoCategory (repo) {
  if (repo.loading) {
      return "Đang tải....";
  }
  var $container = $(
      "<div class='select2-result-repository clearfix d-flex'>" +
          "<div class='select2-result-repository__meta ml-2'>" +
              "<div class='select2-result-repository__statistics'>" +
              "<span class='select2-result-repository__forks'></span>" +
              "<span class='select2-result-repository__stargazers'></span>" +
              "</div>" +
          "</div>" +
      "</div>"
  );

  $container.find(".select2-result-repository__forks").append(repo.id + ". " + repo.name);
  return $container;
}

function formatRepoCategorySelection (repo) {
  if (repo.name) {
      var str = repo.name;
      return str;
  }
  return 'Tìm kiếm danh mục...';
}
