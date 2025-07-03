$(document).ready(function () {
    // Handle delete
    $(document).on('click', '.btn-delete-app-log', function () {
        var id = $(this).data('id');
        if (!confirm('Yakin ingin menghapus log ini?')) return;
        var btn = $(this);
        btn.prop('disabled', true);
        $.ajax({
            url: '/app-logs/' + id,
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
                    alert(res.message || 'Gagal menghapus log.');
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