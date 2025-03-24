<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="QTrack - Sistem Antrian Online">
    <meta name="author" content="">

    <title>QTrack - <?= $title; ?></title>

    <!-- Custom fonts -->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts -->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #4e73df;
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header h2 {
            color: white;
            margin-bottom: 0;
        }

        .address {
            text-align: center;
            margin-top: 10px;
            font-size: 16px;
            color: rgb(249, 191, 0);
        }

        .container-body {
            flex: 1;
            margin-top: 30px;
            padding-bottom: 20px; /* Memberikan jarak antara konten dan footer */
        }

        .footer {
            background-color: #4e73df;
            padding: 20px;
            border-top: 1px solid #e3e6f0;
            text-align: center;
            font-size: 14px;
            color: white;
        }

        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .custom-card-header {
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }

        .custom-card-footer {
            background: #f8f9fa;
            border-radius: 0 0 15px 15px;
            padding: 10px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
        }

        /* Navbar Modern */
        .navbar {
            background-color: #36b9cd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: white;
            font-weight: 500;
            margin: 0 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color:white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
        }

       


        .navbar-toggler {
            border: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>QTRACK</h2>
        <div class="address">
            Bank Muamalat KC Karawang
        </div>
    </div>

    <!-- Navbar Modern -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link" href="<?=base_url('UserController');?>">Home</a>
                    <a class="nav-item nav-link" href="<?=base_url('UserController/ambil_antrian');?>">Ambil Antrian</a>
                    <a class="nav-item nav-link" href="<?=base_url('UserController/histori');?>">Histori</a>
                    <a class="nav-item nav-link" href="<?=base_url('AuthController/logout');?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-body d-flex flex-column">
        <?php $this->load->view($conten); ?>
    </div>

    <script>
        $(document).ready(function() {
            var currentUrl = "<?= uri_string(); ?>"; // Ambil URI segment saat ini

            $('.navbar-nav .nav-link').each(function() {
                var linkUrl = $(this).attr('href').split('/').pop(); // Ambil segment terakhir dari URL

                if (currentUrl === linkUrl) {
                    $(this).addClass('active'); // Tambahkan class 'active' jika cocok
                }
            });
        });
    </script>

    <div class="footer">
        &copy; 2025 QTrack. All rights reserved. | Designed by <a href="#" style="color:rgb(255, 191, 0);">Rofi</a>
    </div>
</body>

</html>