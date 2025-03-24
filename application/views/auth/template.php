
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>QTrack - <?= $title;?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/');?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/');?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/');?>vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/');?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/');?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/');?>js/sb-admin-2.min.js"></script>

    <script src="<?= base_url('assets/');?>vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
        
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .floating-label__text {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            transition: all 0.2s ease;
            color: #999;
            font-size: 1rem;
        }

        .floating-label input:focus ~ .floating-label__text,
        .floating-label input:not(:placeholder-shown) ~ .floating-label__text {
            top: -20px;
            font-size: 0.8rem;
            color: #007bff;
        }

        .input-border-bottom {
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .input-border-bottom:focus {
            outline: none;
            border-bottom: 2px solid #007bff;
        }

      .btn-user {
            background-color: #007bff; /* Button background color */
            border: none; /* Remove border */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition for background color */
        }

        .btn-user:hover {
            background-color: #0056b3; /* Darker background on hover */
            transform: scale(1.05); /* Slightly scale up on hover */
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-xl-5 col-lg-5 col-md-4">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <?php $this->load->view('auth/'.$page);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>



    <script>
        function showSweetAlert(icon, title, redirectUrl = null) {
            Swal.fire({
                icon: icon, // 'success', 'error', 'warning', 'info', 'question'
                title: icon,
                text: title,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6', // Warna tombol
                backdrop: 'rgba(0,0,0,0.5)', // Latar belakang semi-transparan
                timer: 3000, // Timer lebih lama (3 detik)
                timerProgressBar: true, // Menampilkan progress bar
                allowOutsideClick: false, // Tidak bisa menutup dengan klik di luar
                allowEscapeKey: false, // Tidak bisa menutup dengan tombol ESC
                customClass: {
                    popup: 'animated bounceIn', // Animasi masuk (bounceIn)
                    title: 'swal2-title-custom', // Custom class untuk judul
                    content: 'swal2-content-custom', // Custom class untuk konten
                }
            }).then((result) => {
                if (result.isConfirmed && redirectUrl) {
                    // Redirect ke halaman tertentu jika redirectUrl diberikan
                    window.location.href = redirectUrl;
                }
            });
        }
        // JavaScript untuk memastikan label tetap di atas saat input terisi
        document.querySelectorAll('.floating-label input').forEach(input => {
            input.addEventListener('input', () => {
                if (input.value.trim() !== "") {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        });
    </script>

</body>

</html>