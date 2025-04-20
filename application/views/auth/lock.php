<div class="text-center p-0 m-0"> 
    <h1 class="h4 text-900 mb-0"><?php echo get_web_info('nama_web'); ?></h1>
    <p class="text-info"><?php echo get_web_info('alamat'); ?></p>
</div>
<form class="user" id="form-login">
   
    <!-- Input pin -->
    <div class="form-group floating-label">
        <input type="pin" class="form-control form-control-user rounded-0 input-border-bottom"
            id="pin" name="pin" placeholder=" " required>
        <label for="pin" class="floating-label__text">PIN</label>
        <span id="pin-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="pin-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <!-- Tombol Login -->
    <button id="button-login" class="btn btn-primary btn-user btn-block mt-4">
        Submit
    </button>
</form>

<script>
    $(document).ready(function() {

        $('#pin').on('keyup', function() {
            let pin = $(this).val();
            if (pin === "") {
                $('#pin-error').text('pin harus diisi.');
                $('#pin-success').text('');
            } else {
                $('#pin-error').text('');
                $('#pin-success').text('pin valid.');
            }
        });



        $('#button-login').on('click', function(e) {
            e.preventDefault();
            $('#email').trigger('keyup');
            $('#pin').trigger('keyup');;

            let hasError = (
                $('#email-error').text() !== "" ||
                $('#pin-error').text() !== ""
            );

            if (!hasError) {
                var dataForm = new FormData(document.getElementById('form-login'));
                $.ajax({
                    url: '<?= site_url('GetAntrian/proses_unlock'); ?>',
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            // Tampilkan SweetAlert sukses dan redirect ke halaman AuthController
                            showSweetAlert(data.status, data.message, '<?= site_url('GetAntrian'); ?>');
                        } else {
                            // Tampilkan SweetAlert error tanpa redirect
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
