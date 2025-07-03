$(document).ready(function(){
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    $('.show_password').on('click', function(e){
        e.preventDefault();
        togglePasswordVisibility(this);
    });

    // Mengambil referensi ke elemen input berdasarkan id
    var phoneInput = document.getElementsByName('phone')[0];

    // Menambahkan event listener untuk event input
    phoneInput.addEventListener('input', function() {
        validateNumericInput(this);
    });

    function validateNumericInput(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter selain angka
    }


    function togglePasswordVisibility(element) {
        var inputElement = element.closest('.input-group').querySelector('input');
        var iconElement = element.querySelector('i');

        if (inputElement.type === 'password') {
            inputElement.type = 'text';
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        } else {
            inputElement.type = 'password';
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        }
    }

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
            if(fieldName == 'name'){
                validationErrors[fieldName].forEach( function (message){
                    if(message == 'validation.string'){
                        errorMessage += "The :attribute must be a string. "+"<br>"
                    }else if(message == 'validation.max.string'){
                        errorMessage += "The :attribute may not be greater than :100 characters."+"<br>"
                    }else if(message == 'validation.required'){
                        errorMessage += "The :attribute field is required."+"<br>"
                    }
                });
            }else if(fieldName == 'email'){
                validationErrors[fieldName].forEach( function (message){
                    if(message == 'validation.email'){
                        errorMessage += "The :attribute must be a valid email address."+"<br>"
                    }else if(message == 'validation.unique'){
                        errorMessage += "The :attribute has already been taken."+"<br>"
                    }else if(message == 'validation.required'){
                        errorMessage += "The :attribute field is required."+"<br>"
                    }
                });
            }else if(fieldName == 'password'){
                validationErrors[fieldName].forEach( function (message){
                    if(message == 'validation.confirmed'){
                        errorMessage += "The :attribute confirmation does not match. "+"<br>"
                    }else if(message == 'validation.min.string'){
                        errorMessage += "The :attribute must be at least :8 characters."+"<br>"
                    }else if(message == 'validation.required'){
                        errorMessage += "The :attribute field is required."+"<br>"
                    }
                });
                // var errorElement2 = document.querySelector('.form-group input[name="password_confirmation"]');
                var errorElement2 = document.getElementsByName('password_confirmation')[0];
                errorElement2.classList.add('is-invalid');
            }else if(fieldName == 'phone'){
                validationErrors[fieldName].forEach( function (message){
                    if(message == 'validation.string'){
                        errorMessage += "The :attribute must be a numeric. "+"<br>"
                    }else if(message == 'validation.max.string'){
                        errorMessage += "The :attribute may not be greater than : 15 characters."+"<br>"
                    }else if(message == 'validation.required'){
                        errorMessage += "The :attribute field is required."+"<br>"
                    }
                });
            }else if(fieldName == 'roles'){
                if(message == 'validation.in'){
                    errorMessage = "The selected :attribute is invalid."+"<br>"
                }else if(message == 'validation.required'){
                    errorMessage += "The :attribute field is required."+"<br>"
                }

            }else if(fieldName == 'account_status'){
                if(message == 'validation.in'){
                    errorMessage = "The selected :attribute is invalid."+"<br>"
                }else if(message == 'validation.required'){
                    errorMessage += "The :attribute field is required."+"<br>"
                }
            }

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

    $('#form_add_user').on('submit', function(e){
        e.preventDefault();

        var form_data = new FormData(this);

        $.ajax({
            url : '/users',
            type : 'post',
            data : form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.status == true){
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.href = '/users';
                    }, 1000); //
                }else{
                    iziToast.error({
                        title: 'Something Wrong !',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(error) {
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
