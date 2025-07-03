$(document).ready(function () {
    // Delete fuel log
    $('.btn-delete-fuel-log').on('click', function (e) {
        e.preventDefault();
        let fuelLogId = $(this).data('id');
        swal({
            title: "Attention",
            text: "Are you sure you want to delete this fuel log?\nID: " + fuelLogId,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((result) => {
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "/fuel-logs/" + fuelLogId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === true) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function (error) {
                        iziToast.error({
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight'
                        });
                    }
                });
            }
        });
    });
}); 