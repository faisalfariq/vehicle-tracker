$(document).ready(function () {
    $(document).on('click', '.btn-delete-service-log', function () {
        var logId = $(this).data('id');
        var row = $(this).closest('tr');
        if (confirm('Are you sure you want to delete this service log?')) {
            $.ajax({
                url: '/service-logs/' + logId,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status == true) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        row.remove();
                    } else {
                        iziToast.error({
                            title: 'Something Wrong !',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function (error) {
                    iziToast.error({
                        title: 'Something Wrong !',
                        message: error.responseJSON.message,
                        position: 'topRight'
                    });
                }
            });
        }
    });
}); 