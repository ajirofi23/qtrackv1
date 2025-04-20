<div class="container">
  <div class="card">
      <div class="card-header">
          <h4 class="mb-0">Histori Antrian Booking</h4>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table id="historiAntrianTable" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>NO</th>
                          <th>No. Antrian</th>
                          <th>Layanan</th>
                          <th>Tanggal</th>
                          <th>Waktu Booking</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $no = 1;
                        foreach ($data_histori as $h) : ?>
                            <tr>
                                <td><?= $no++;?></td>
                                <td><?= $h['no_antrian'];?></td>
                                <td><?= $h['nama_layanan'];?></td>
                                <td><?= date('d-m-Y',strtotime($h['waktu_buat']));?></td>
                                <td><?= $h['waktu_booking'];?></td>
                                <td>
                                    <?php
                                    // Determine status and badge color based on $h['status_antrian']
                                    if ($h['status_antrian'] == 'buat') {
                                        $sa = 'Menunggu Dipanggil';
                                        $badge_color = 'badge-secondary';
                                    } elseif ($h['status_antrian'] == 'panggil') {
                                        $sa = 'Sedang Dipanggil';
                                        $badge_color = 'badge-primary';
                                    } elseif ($h['status_antrian'] == 'proses') {
                                        $sa = 'Sedang Dilayani';
                                        $badge_color = 'badge-info';
                                    } elseif ($h['status_antrian'] == 'selesai') {
                                        $sa = 'Selesai';
                                        $badge_color = 'badge-success';
                                    } elseif ($h['status_antrian'] == 'batal') {
                                        $sa = 'Dibatalkan';
                                        $badge_color = 'badge-danger';
                                    } else {
                                        $sa = 'Status Tidak Dikenali';
                                        $badge_color = 'badge-dark';
                                    }
                                    ?>
                                    <span class="badge <?php echo $badge_color; ?>"><?php echo $sa; ?></span>
                                </td>
                               
                            </tr>
                        <?php endforeach;?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>