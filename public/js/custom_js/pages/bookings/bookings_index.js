$(document).ready(function () {

    $('.btn-delete-booking').on('click', function (e) {
        e.preventDefault();
        var bookingId = $(this).data('id');
        let booking_name = $(this).closest('tr').find('td').eq(0).text().trim();

        swal({
            title: "Attention",
            text: "Are you sure you want to delete this booking ?\nBooking code : " + booking_name,
            icon: "warning",
            buttons: "Ok",
            confirmButtonColor: '#4b68ef',
            dangerMode: true,
        }).then((result) => {
            if (result) {
                $.ajax({
                    type: "delete",
                    url: "/bookings/" + bookingId,
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == true) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });
                            setTimeout(function () {
                                window.location.href = '/bookings';
                            }, 1000); //
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
});
