$(document).ready(function () {
    $(document).on('click', '.btn-delete-region', function () {
        var regionId = $(this).data('id');
        var row = $(this).closest('tr');
        if (confirm('Are you sure you want to delete this region?')) {
            $.ajax({
                url: '/regions/' + regionId,
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