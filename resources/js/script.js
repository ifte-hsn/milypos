/**
 * Custom Scripts
 */
(function ($) {
    var Components = {};
    Components.modals = {};
    // confirm delete modal
    Components.modals.confirmDelete = function () {
        var $el = $('table');

        var events = {
            'click': function (evnt) {
                var $context = $(this);
                var $dataConfirmModal = $('#dataConfirmModal');
                var href = $context.attr('href');
                var message = $context.attr('data-content');
                var title = $context.attr('data-title');
                var token = $('meta[name="csrf-token"]').attr('content');

                $('#myModalLabel').text(title);
                $dataConfirmModal.find('.modal-body').text(message);
                $('#deleteForm').attr('action', href);
                $dataConfirmModal.modal({
                    show: true
                });

                return false;
            }
        };

        var render = function () {
            $el.on('click', '.delete-asset', events['click']);
        };

        return {
            render: render
        };
    };


    /**
     * Application start point
     * Component definition stays out of load event, execution only happens.
     */
    $(function () {
        new Components.modals.confirmDelete().render();
    });

    $('select.select2:not(".select2-hidden-accessible")').each(function (i, obj) {
        {
            $(obj).select2();
        }
    });


    /**
     * iCheck
     */
    $('input[type="checkbox"], input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });

    /**
     * Input musk
     */
    $('[data-mask]').inputmask();

}(jQuery));

$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});


// Image preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result)
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function formatBytes(bytes) {
    if (bytes < 1024) return bytes + 'Bytes';
    else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + " KB";
    else if (bytes < 1073741824) return (bytes / 1048576).toFixed(2) + " MB";
    else return (bytes / 1073741824).toFixed(2) + " GB";
}

// File size validation
$('#uploadFile').bind('change', function () {
    $('#upload-file-status').removeClass('text-success').removeClass('text-danger');
    $('.goodfile').remove();
    $('.badfile').remove();
    $('.previewSize').hide();
    $('#upload-file-info').html('');

    var max_size = $('#uploadFile').data('maxsize');
    var total_size = 0;

    for (var i = 0; i < this.files.length; i++) {
        total_size += this.files[i].size;
        $('#upload-file-info').append('<span class="label label-default">' + this.files[i].name + '(' + formatBytes(this.files[i].size) + ')' + '</span>');
    }

    if (total_size > max_size) {
        $('#upload-file-status').addClass('text-danger').removeClass('help-block').prepend('<i class="badfile fa fa-times"></i>').append('<span class="previewSize"> Upload is ' + formatBytes(total_size) + '</span>')
    } else {
        $('#upload-file-status').addClass('text-success').removeClass('help-block').prepend('<i class="goodfile fa fa-check"></i>');
        readURL(this);
        $('#imagePreview').fadeIn();
    }
});
