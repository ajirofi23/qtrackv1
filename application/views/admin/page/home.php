<div class="alert alert-primary" role="alert" style="border-left: 5px solid #007bff; border-radius: 8px;">
  <div class="d-flex align-items-center">
    <i class="fas fa-user-circle fa-2x mr-3" style="color: #007bff;"></i>
    <div>
      <h4 class="alert-heading mb-2" style="font-weight: 600; color: #007bff;">Selamat Datang, <?= $this->session->userdata('username');?>!</h4>
      <p class="mb-2" style="font-size: 1rem; color: #004085;">
        Kami senang Anda bergabung dengan kami. Mulailah menjelajahi fitur-fitur yang tersedia dan nikmati pengalaman terbaik bersama sistem kami.
      </p>
      <hr style="border-top: 1px solid #007bff;">
      <p class="mb-0" style="font-size: 0.9rem; color: #004085;">
        Jika Anda membutuhkan bantuan, jangan ragu untuk menghubungi tim dukungan kami.
      </p>
    </div>
  </div>
</div>