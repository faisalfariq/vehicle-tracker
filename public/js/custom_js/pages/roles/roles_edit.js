$(document).ready(function () {
    function validateForm(validationErrors) {
        // Reset error messages
        var errorDivs = document.querySelectorAll('.invalid-feedback');
        errorDivs.forEach(function (errorDiv) {
            errorDiv.innerHTML = '';
        });

        var formInputs = document.querySelectorAll('.form-group input');
        formInputs.forEach(function (input) {
            input.classList.remove('is-invalid');
        });

        // Process validation errors
        Object.keys(validationErrors).forEach(function (fieldName) {
            var errorMessage = '';
            validationErrors[fieldName].forEach(function (message) {
                errorMessage += message + "<br>";
            });

            var errorElement = document.getElementsByName(fieldName)[0];
            var errorClass = fieldName + "_error";
            var errorDivs = document.querySelectorAll('.' + errorClass);

            if (errorElement) {
                errorElement.classList.add('is-invalid');
            }

            errorDivs.forEach(function (errorDiv) {
                errorDiv.innerHTML = errorMessage;
            });
        });

        // If any validation fails, prevent form submission
        if (Object.keys(validationErrors).length > 0) {
            event.preventDefault();
        }
    }

    $('#form_edit_role').on('submit', function (e) {
        e.preventDefault();

        let formURL = $(this).attr('action');
        var form_data = new FormData(this);

        $.ajax({
            url: formURL,
            method: 'POST',
            data: form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == true) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    setTimeout(function () {
                        window.location.href = '/roles';
                    }, 1000);
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
                validateForm(error.responseJSON.errors)
            }
        });
    });
}); 