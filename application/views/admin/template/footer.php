<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('AuthController/logout');?>">Logout</a>
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
   </script>
   <?php if ($this->session->flashdata('swal')): ?>
        <script>
            Swal.fire({
                icon: '<?= $this->session->flashdata('swal')['icon'] ?>',
                title: '<?= $this->session->flashdata('swal')['title'] ?>',
                text: '<?= $this->session->flashdata('swal')['text'] ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>

</html>