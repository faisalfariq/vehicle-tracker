$(document).ready(function () {
    $('#form_edit_vehicle_type').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        btn.prop('disabled', true);
        form.find('.invalid-feedback').text('');
        form.find('.form-control').removeClass('is-invalid');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize() + '&_method=PUT',
            success: function (res) {
                if (res.status) {
                    alert(res.message);
                    window.location.href = '/vehicle-types';
                } else {
                    alert(res.message || 'Gagal update tipe kendaraan.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, val) {
                        form.find('[name="' + key + '"]').addClass('is-invalid');
                        form.find('.' + key + '_error').text(val[0]);
                    });
                } else {
                    alert('Terjadi kesalahan.');
                }
            },
            complete: function () {
                btn.prop('disabled', false);
            }
        });
    });
}); 