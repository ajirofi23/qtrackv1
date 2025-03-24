<div class="text-center p-0 m-0">
    <h1 class="h4 text-900 mb-0">QTRACK</h1>
    <p class="text-info">Bank Muamalat KC Karawang</p>
</div>
<form class="user" id="form-register">
    <div class="form-group floating-label">
        <input type="text" class="form-control form-control-user rounded-0 input-border-bottom"
            id="fullname" placeholder=" " name="nama_lengkap" required>
        <label for="fullname" class="floating-label__text">Nama Lengkap</label>
        <span id="fullname-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="fullname-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <div class="form-group floating-label">
        <input type="tel" class="form-control form-control-user rounded-0 input-border-bottom"
            id="phoneNumber" placeholder=" " name="no_tlp" required>
        <label for="phoneNumber" class="floating-label__text">Nomor Telepon</label>
        <span id="phoneNumber-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="phoneNumber-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <div class="form-group floating-label">
        <input type="email" class="form-control form-control-user rounded-0 input-border-bottom"
            id="email" placeholder=" " name="email" required>
        <label for="email" class="floating-label__text">Alamat Email</label>
        <span id="email-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="email-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <div class="form-group floating-label">
        <input type="password" class="form-control form-control-user rounded-0 input-border-bottom"
            id="password" placeholder=" " name="password" required>
        <label for="password" class="floating-label__text">Password</label>
        <span id="password-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="password-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <div class="form-group floating-label">
        <input type="password" class="form-control form-control-user rounded-0 input-border-bottom"
            id="confirmPassword" placeholder=" " required>
        <label for="confirmPassword" class="floating-label__text">Konfirmasi Password</label>
        <span id="confirmPassword-error" class="text-danger" style="font-size: 12px !important;"></span>
        <span id="confirmPassword-success" class="text-success" style="font-size: 12px !important;"></span>
    </div>

    <button id="button-daftar" class="btn btn-primary btn-user btn-block mt-4">
        Daftar
    </button>
</form>
<hr>
<div class="text-center">
    <a class="small" href="<?=base_url('AuthController');?>">Login!</a>
</div>

<script>
    $(document).ready(function() {

        $('#fullname').on('keyup', function() {
            let fullname = $(this).val();
            if (fullname === "") {
                $('#fullname-error').text('Nama lengkap harus diisi.');
                $('#fullname-success').text('');
            } else {
                $('#fullname-error').text('');
                $('#fullname-success').text('Nama lengkap valid.');
            }
        });

        $('#phoneNumber').on('keyup', function() {
            let phoneNumber = $(this).val();
            if (phoneNumber === "") {
                $('#phoneNumber-error').text('Nomor telepon harus diisi.');
                $('#phoneNumber-success').text('');
            } else if (!/^\d+$/.test(phoneNumber)) {
                $('#phoneNumber-error').text('Nomor telepon harus berupa angka.');
                $('#phoneNumber-success').text('');
            } else {
                $('#phoneNumber-error').text('');
                $('#phoneNumber-success').text('Nomor telepon valid.');
            }
        });

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
            } else if (password.length < 8) {
                $('#password-error').text('Password minimal 8 karakter.');
                $('#password-success').text('');
            } else {
                $('#password-error').text('');
                $('#password-success').text('Password valid.');
            }
        });

        $('#confirmPassword').on('keyup', function() {
            let confirmPassword = $(this).val();
            let password = $('#password').val();
            if (confirmPassword === "") {
                $('#confirmPassword-error').text('Konfirmasi password harus diisi.');
                $('#confirmPassword-success').text('');
            } else if (confirmPassword !== password) {
                $('#confirmPassword-error').text('Konfirmasi password tidak sesuai.');
                $('#confirmPassword-success').text('');
            } else {
                $('#confirmPassword-error').text('');
                $('#confirmPassword-success').text('Konfirmasi password valid.');
            }
        });

        $('#button-daftar').on('click', function(e) {
            e.preventDefault();

            $('#fullname').trigger('keyup');
            $('#phoneNumber').trigger('keyup');
            $('#email').trigger('keyup');
            $('#password').trigger('keyup');
            $('#confirmPassword').trigger('keyup');

            let hasError = (
                $('#fullname-error').text() !== "" ||
                $('#phoneNumber-error').text() !== "" ||
                $('#email-error').text() !== "" ||
                $('#password-error').text() !== "" ||
                $('#confirmPassword-error').text() !== ""
            );

            if (!hasError) {
                var dataForm = new FormData(document.getElementById('form-register'));

                // Fungsi untuk menampilkan SweetAlert


                $.ajax({
                    url: '<?= site_url('AuthController/proses_register'); ?>',
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        console.log(data);

                        if (data.status === 'success') {
                            // Tampilkan SweetAlert sukses dan redirect ke halaman AuthController
                            showSweetAlert(data.status, data.message, '<?= site_url('AuthController/konfirmasi'); ?>');
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