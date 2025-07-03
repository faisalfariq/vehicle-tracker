$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    function validateForm(errors) {
        $('.invalid-feedback').html('');
        $('.form-control').removeClass('is-invalid');
        $.each(errors, function (field, messages) {
            let errorClass = '.' + field + '_error';
            let input = '[name="' + field + '"]';
            $(input).addClass('is-invalid');
            $(errorClass).html(messages.join('<br>'));
        });
    }

    $('#form_edit_fuel_log').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let actionUrl = $(this).attr('action');
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === true) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    setTimeout(function () {
                        window.location.href = '/fuel-logs/' + response.fuel_log_id;
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
                if (error.responseJSON.errors) {
                    validateForm(error.responseJSON.errors);
                }
            }
        });
    });
}); 