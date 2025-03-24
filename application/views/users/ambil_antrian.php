<style>
  .btn-custom {
      width: 100%;
      margin-top: 20px;
      padding: 15px;
      font-size: 18px;
      font-weight: bold;
  }

  .video-container {
      text-align: center;
      margin-bottom: 30px;
  }

  video {
      width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
</style>
<!-- Outer Row -->
<div class="container">
  
  <div class="row justify-content-center mt-5">
      <div class="col-md-6 video-container">
          <h2 class="text-primary">Video Layanan</h2>
          <video controls>
              <source src="path_to_your_video.mp4" type="video/mp4">
              Browser Anda tidak mendukung tag video.
          </video>
      </div>

      <div class="col-md-6">
          <h2 class="text-primary text-center">Layanan</h2>
          <div class="row">
              <?php foreach ($data_layanan as $dl) : ?>
                  <div class="col">
                      <button class="btn btn-success btn-custom" onclick="ambilAntrian('<?= $dl['id_layanan']; ?>', '<?= $dl['kode']; ?>', '<?= $dl['nama']; ?>')">
                          <?= $dl['nama']; ?>
                      </button>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
  </div>
</div>