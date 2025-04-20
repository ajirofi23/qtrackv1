<div class="card shadow mb-4">
      <div class="card-header py-3">
          <a href="<?=base_url('BookingController/tambah');?>" class="btn btn-sm btn-primary" id="btn-tambah">Tambah</a>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th style="width: 5px;" class="text-center">NO</th>
                          <th class="text-center">WAKTU AWAL</th>
                          <th class="text-center">WAKTU AKHIR</th>
                          <th class="text-center">MAKSIMAL ANTRIAN</th>
                          <th style="width: 20%;" class="text-center">ACTION</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $no=1;
                      foreach ($data_waktu as $row) :
                      ?>
                        <tr>
                          <td  style="width: 5px;" class="text-center"><?=$no++;?></td>
                          <td><?= $row['waktu_awal'];?></td>
                          <td><?= $row['waktu_akhir'];?></td>
                          <td><?= $row['maks_antrian'];?></td>
                          <td style="width: 20%;"  class="text-center">
                              <a href="<?= base_url('BookingController/edit/').$row['id_waktu_booking'];?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>  
                              <a href="<?= base_url('BookingController/hapus/').$row['id_waktu_booking'];?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>  
                          </td>
                        </tr>
                      <?php endforeach;?>
                      
                  </tbody>
              </table>
          </div>
      </div>
  </div>