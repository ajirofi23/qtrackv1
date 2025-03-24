<div class="text-center p-0 m-0">
    <h1 class="h4 text-900 mb-0">QTRACK</h1>
    <p class="text-info">Bank Muamalat KC Karawang</p>
</div>
<form class="user" id="form-konfirmasi">
    <div class="form-group floating-label">
        <input type="text" class="form-control form-control-user rounded-0 input-border-bottom"
            id="token" placeholder=" " name="token" required>
        <label for="token" class="floating-label__text">Kode Konfirmasi</label>
        <span id="token-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="token-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <button id="button-konfirmasi" class="btn btn-primary btn-user btn-block mt-4">
        Konfirmasi
    </button>
</form>

<script>
    $(document).ready(function() {

        $('#token').on('keyup', function() {
            let token = $(this).val();
            if (token === "") {
                $('#token-error').text('Kode konfirmasi harus diisi.');
                $('#token-success').text('');
            } else {
                $('#token-error').text('');
                $('#token-success').text('Kode konfirmasi valid.');
            }
        });

        
        $('#button-konfirmasi').on('click', function(e) {
            e.preventDefault();

            $('#token').trigger('keyup');
        
            let hasError = ($('#token-error').text() !== "");

            if (!hasError) {
                var dataForm = new FormData(document.getElementById('form-konfirmasi'));

                // Fungsi untuk menampilkan SweetAlert
                $.ajax({
                    url: '<?= site_url('AuthController/proses_konfirmasi'); ?>',
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        console.log(data);

                        if (data.status === 'success') {
                            // Tampilkan SweetAlert sukses dan redirect ke halaman AuthController
                            showSweetAlert(data.status, data.message, '<?= site_url('AuthController/index'); ?>');
                        } else if (data.status === 'info') {
                            // Tampilkan SweetAlert error tanpa redirect
                            showSweetAlert(data.status, data.message,'<?= site_url('AuthController/index'); ?>');
                        }else{
                            showSweetAlert(data.status, data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan SweetAlert untuk error AJAX
                        showSweetAlert('error', 'Terjadi kesalahan: ' + error);
                    }
                });
            }
        });
    });
</script>