$(document).ready(function () {
    // Handle delete
    $(document).on('click', '.btn-delete-vehicle-type', function () {
        var id = $(this).data('id');
        if (!confirm('Yakin ingin menghapus tipe kendaraan ini?')) return;
        var btn = $(this);
        btn.prop('disabled', true);
        $.ajax({
            url: '/vehicle-types/' + id,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.status) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message || 'Gagal menghapus tipe kendaraan.');
                }
            },
            error: function (xhr) {
                alert('Terjadi kesalahan.');
            },
            complete: function () {
                btn.prop('disabled', false);
            }
        });
    });
}); 