tinymce.init({
    selector:'#item-content',
    height: 600,
    'plugins': [
        'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code table paste media  hr anchor pagebreak  wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality emoticons template paste textpattern imagetools'
    ],
    'toolbar': 'styleselect  | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  image media | code  print | forecolor backcolor fullscreen',
    'extended_valid_elements': "script[language|type|async|src|charset]",
    'image_dimensions': false,
    // without images_upload_url set, Upload tab won't show up
    images_upload_handler: function (blobInfo, success, failure) {
      var xhr, formData;

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', '/upload');

      xhr.onload = function() {
        var json;

        if (xhr.status != 200) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }

        success(json.location);
      };

      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      xhr.send(formData);
    }
});

function addItem() {
    $("#formItem").attr('action', '/notify/template/create');
    $("#modalItem").modal('show');
}

function editItem(id) {
    if (!id || id <= 0) {
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Xảy ra lỗi', 'Email template không xác định');
        return false;
    }

    $.ajax({
        type: 'GET',
        url: '/notify/template/detail/' + id,
        success: function (res) {
            $("#formItem").attr('action', '/notify/template/update/' + id);

            $('#item-name').val(res.item.name);
            tinymce.get('item-content').setContent(res.item.content);
            $('#modalItem').modal('show');
        }
    });

    return false;
}

$('#formItem').bind('form-pre-serialize', function(e) {
    tinyMCE.triggerSave();
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
    $("#formItem").attr('action', '/notify/template/create').trigger('reset');
});

$('input[name="template_type"]').change(function() {
    var type = $(this).val();
    $.ajax({
        type: 'GET',
        url: '/notify/template/sample/' + type,
        success: function (res) {
            tinymce.get('item-content').setContent(res.content);
        }
    });
    return false;
});
