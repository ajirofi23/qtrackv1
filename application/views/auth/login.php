<div class="text-center p-0 m-0"> 
    <h1 class="h4 text-900 mb-0">QTRACK</h1>
    <p class="text-info">Bank Muamalat KC Karawang</p>
</div>
<form class="user" id="form-login">
    <!-- Input Email -->
    <div class="form-group floating-label">
        <input type="email" class="form-control form-control-user rounded-0 input-border-bottom"
            id="email" placeholder=" " name="email" required>
        <label for="email" class="floating-label__text">Alamat Email</label>
        <span id="email-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="email-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <!-- Input Password -->
    <div class="form-group floating-label">
        <input type="password" class="form-control form-control-user rounded-0 input-border-bottom"
            id="password" name="password" placeholder=" " required>
        <label for="password" class="floating-label__text">Password</label>
        <span id="password-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="password-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <!-- Tombol Login -->
    <button id="button-login" class="btn btn-primary btn-user btn-block mt-4">
        Login
    </button>
</form>
<hr>
<div class="text-center">
    <a class="small" href="<?=base_url('AuthController/register');?>">Registrasi!</a>
</div>

<script>
    $(document).ready(function() {

        $('#email').on('keyup', function() {
            let email = $(this).val();
            if (email === "") {
                $('#email-error').text('Email harus diisi.');
                $('#email-success').text('');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                $('#email-error').text('Format email tidak valid.');
                $('#email-success').text('');
            } else {
                $('#email-error').text('');
                $('#email-success').text('Email valid.');
            }
        });

        $('#password').on('keyup', function() {
            let password = $(this).val();
            if (password === "") {
                $('#password-error').text('Password harus diisi.');
                $('#password-success').text('');
            } else {
                $('#password-error').text('');
                $('#password-success').text('Password valid.');
            }
        });



        $('#button-login').on('click', function(e) {
            e.preventDefault();
            $('#email').trigger('keyup');
            $('#password').trigger('keyup');;

            let hasError = (
                $('#email-error').text() !== "" ||
                $('#password-error').text() !== ""
            );

            if (!hasError) {
                var dataForm = new FormData(document.getElementById('form-login'));
                $.ajax({
                    url: '<?= site_url('AuthController/proses_login'); ?>',
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            // Tampilkan SweetAlert sukses dan redirect ke halaman AuthController
                            showSweetAlert(data.status, data.message, '<?= site_url('HomeController'); ?>');
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
