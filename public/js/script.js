(function($) {
    var Components = {};
    Components.modals = {};
    // confirm delete modal
    Components.modals.confirmDelete = function() {
        var $el = $('table');

        var events = {
            'click': function(evnt) {
                var $context = $(this);
                var $dataConfirmModal = $('#dataConfirmModal');
                var href = $context.attr('href');
                var message = $context.attr('data-content');
                var title = $context.attr('data-title');
                var token = $('meta[name="csrf-token"]').attr('content');

                $('#myModalLabel').text(title);
                $dataConfirmModal.find('.modal-body').text(message);
                $('#deleteForm').attr('action', href);
                // $dataConfirmModal.modal({
                //     show: true
                // });


                swal({
                    title: title,
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: 'delete',
                            url: href,
                            data : { '_token' : token },
                            success: function (data) {
                                if(data.status === 'success') {
                                    swal(data.messages, {
                                        icon: "success",
                                    }).then((reload) => {
                                        location.reload();
                                    });

                                } else {
                                    swal("there are an error while deleting user", {
                                        icon: "success",
                                    });
                                }
                            }
                        });


                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });





                return false;
            }
        };

        var render = function() {
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
    $(function() {
        new Components.modals.confirmDelete().render();
    });


}(jQuery));