function get_extension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1].toLowerCase();
}
$(document).ready(function () {
    var UPLOAD_MAX_SIZE = 5;

    //begin upload file
    $('#form-upload').ajaxForm({
        beforeSend: function (xhr, opts) {
            if (!($('#file_input')[0].files[0].size < (UPLOAD_MAX_SIZE * 1024 * 1024) && (['jpg', 'jpeg', 'png', 'gif', 'pdf']).indexOf(get_extension($('#file_input').val())) > -1)) { // 10 MB (this size is in bytes)

                alert('Only accept file (jpg, png, gif) maximum ' + UPLOAD_MAX_SIZE + 'MB');
                xhr.abort();
                return false;
            }
            var percentVal = '0%';
            $(this_click_btn).html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            $(this_click_btn).html(percentVal);
        },
        success: function (res) {
            if (res.status == 1) {
                upload_success(res);
                if (submit_form) {
                    $('#' + submit_form).submit();
                }
            } else {
                alert(res.message);
            }
        },
        complete: function (xhr) {
            $('#file_input').val('');
            $(this_click_btn).html(text_tmp);
        }
    });

    var input_id;
    var img_id;
    var crop_width;
    var crop_height;
    var text_tmp;
    var this_click_btn;
    var submit_form = false;

    $('.upload_button').click(function () {
        submit_form = false;
        if ($(this).data('submit-form') !== 'undefined') {
            submit_form = $(this).data('submit-form');
        }
        input_id = $(this).data('insert-id');
        img_id = $(this).data('img-id');
        text_tmp = $(this).html();
        this_click_btn = this;
        $('#crop_width').val($(this).data('crop-width'));
        $('#crop_height').val($(this).data('crop-height'));
        $('#file_input').click();
    });

    upload_success = function (res) {
        console.log(res);
        console.log(input_id);
        $('#' + input_id).val(res.data.file).change();
        $('#' + img_id).html('<img class="upload-image__area" src="' + res.data.file + '" />').removeClass("upload-image__area");

        $('#' + input_id).trigger('input');
        $('#' + input_id).trigger('change');
    };
});
