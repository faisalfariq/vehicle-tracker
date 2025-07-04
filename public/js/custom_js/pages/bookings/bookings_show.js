$(document).ready(function() {
    // Get CSRF token from meta tag
    var token = $('meta[name="csrf-token"]').attr('content');
    
    $('form').submit(function(e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let type = $(this).find('button[type=submit]:focus').data('type') || $(this).data('type');
        let booking_code = $('#booking_code').text();
        swal({
            title: "Attention",
            text: "Are you sure you want to " + type + " this booking ?\nBooking code : " + booking_code,
            icon: "warning",
            buttons: "Ok",
            confirmButtonColor: '#4b68ef', 
            dangerMode: true,
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        if (response.status) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000); //
                        } else {
                            iziToast.error({
                                title: 'Something Wrong !',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let message = 'Booking approval failed';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        iziToast.error(message);
                    }
                });
            }
        });
    });
});