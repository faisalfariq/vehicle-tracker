$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    })

    $(".datetimepicker").daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        locale: { format: "YYYY-MM-DD HH:mm" },
        drops: "down",
        opens: "right",
    });

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
            // var errorMessage = validationErrors[fieldName][0];
            var errorMessage = '';
            validationErrors[fieldName].forEach(function (message) {
                errorMessage += message + "<br>";
                // if (message === 'validation.required') {
                //     errorMessage += "This field is required.<br>";
                // } else if (message === 'validation.exists') {
                //     errorMessage += "The selected value is invalid.<br>";
                // } else if (message === 'validation.date') {
                //     errorMessage += "The date format is invalid.<br>";
                // } else if (message === 'validation.after') {
                //     errorMessage += "The date must be after the start date.<br>";
                // } else if (message === 'validation.max.string') {
                //     errorMessage += "The value exceeds the maximum allowed characters.<br>";
                // } else if (message === 'validation.min.array') {
                //     errorMessage += "Please select at least 2 approvers.<br>";
                // } else if (message === 'validation.array') {
                //     errorMessage += "The data format is invalid.<br>";
                // } else {
                //     errorMessage += message + "<br>";
                // }
            });

            // var errorElement = document.querySelector('.form-group input[name='+fieldName+']');
            var errorElement = document.getElementsByName(fieldName)[0];
            var errorClass = fieldName + "_error";
            var errorDivs = document.querySelectorAll('.' + errorClass);

            errorElement.classList.add('is-invalid');

            errorDivs.forEach(function (errorDiv) {
                errorDiv.innerHTML = errorMessage;
            });

        });

        // If any validation fails, prevent form submission
        if (Object.keys(validationErrors).length > 0) {
            event.preventDefault();
        }
    }

    $('#form_edit_booking').on('submit', function (e) {
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
                        window.location.href = formURL;
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

