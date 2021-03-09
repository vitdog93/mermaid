/**
 * Created by ThinkKING on 3/27/19.
 */
/*--------------------------------------
 Bootstrap Notify Notifications
 ---------------------------------------*/
$('.top-menu li.dropdown').hover(function() {
    $(this).parent().find('.show').removeClass('show');
    $(this).addClass('show').find('.dropdown-menu').addClass('show');
});

$('.top-menu li.dropdown').mouseout(function(e) {
    var target = e.relatedTarget;
    if (target.className != 'dropdown-menu show' && target.className != 'dropdown-item pl-3' && target.className != '') {
        $(this).removeClass('show').find('.dropdown-menu').removeClass('show');
    }
});

function notify(icon, type, title, message) {
    $.notify({
        icon: icon,
        title: title,
        message: message,
        url: ''
    }, {
        element: 'body',
        type: type,
        allow_dismiss: true,
        placement: {
            from: 'top',
            align: 'right'
        },
        offset: {
            x: 5, // Keep this as default
            y: 75  // Unless there'll be alignment issues as this value is targeted in CSS
        },
        spacing: 10,
        z_index: 1031,
        delay: 2500,
        timer: 1000,
        url_target: '_blank',
        mouse_over: false,
        template: '<div data-notify="container" class="alert alert-dismissible alert-{0} alert--notify" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title"><strong>{1}</strong></span>: ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '<button type="button" aria-hidden="true" data-notify="dismiss" class="alert--notify__close"><i class="zmdi zmdi-close zmdi-hc-fw"></i></button>' +
            '</div>'
    });
}

$('body').on('click', ".page-link-ajax", function() {
  var page = $(this).data('page');
  var fn = $(this).parent().parent().data('fn');
  if (page && fn) {
    eval(fn + '('+page+')');
  }
});

$('input.integer').number(true, 0);
$('input.float').number(true, 2);

var imgId = '';
$('body').on('click', ".upload button", function() {
    imgId = $(this).data('img-id');
    $(this).prev().click();
});

$('body').on('change', ".upload input", function() {
  var xhr, formData;
  var input = $(this);

  var parts = input.val().split('.');
  var ext = parts[parts.length - 1].toLowerCase();
  if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif', 'pdf']) == -1) {
      notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', 'File upload not allow. Only accept file (jpg, jpeg, png, gif, pdf)!');
      return false;
  }

  xhr = new XMLHttpRequest();
  xhr.withCredentials = false;

  xhr.open('POST', '/upload/static');
  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

  xhr.onload = function() {
    var json;

    if (xhr.status != 200) {
      var res = eval("(" + xhr.responseText + ")");
      notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', res.message);
      return;
    }

    json = JSON.parse(xhr.responseText);

    if (!json || typeof json.location != 'string') {
      notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', 'Error', 'Invalid JSON: ' + xhr.responseText);
      return;
    }

    input.parent().prev().val(json.location).trigger('change');
    $('#' + imgId).html('<img src="' + json.location + '" />').removeClass("upload-image__area");

    // notify('zmdi zmdi-check zmdi-hc-fw', 'success', 'Success', "Upload success");
  };

  formData = new FormData();
  formData.append('file', input[0].files[0]);

  xhr.send(formData);
});

$('body').on('click', ".image-item i", function() {
    if($(this).parent().data('single-upload') == true) {
        $(this).parent().prev().show();
    }
    $(this).parent().parent().children().last().show();
    $(this).parent().remove();
});
