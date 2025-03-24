<div class="card shadow mb-4">
      <div class="card-header py-3">
          <a href="<?=base_url('UserManagementController/tambah');?>" class="btn btn-sm btn-primary" id="btn-tambah">Tambah</a>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th class="text-center">NO</th>
                          <th class="text-center">ID USER</th>
                          <th class="text-center">NAMA LENGKAP</th>
                          <th class="text-center">EMAIL</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center">ACTION</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $no=1;
                      foreach ($data_users as $row) :
                      ?>
                        <tr>
                          <td class="text-center"><?=$no++;?></td>
                          <td><?= $row['id_user'];?></td>
                          <td><?= $row['nama_lengkap'];?></td>
                          <td><?= $row['email'];?></td>
                          <td><?= $row['role'];?></td>
                          <td class="text-center">
                              <a href="<?= base_url('UserManagementController/edit/').$row['id_user'];?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>  
                              <a href="<?= base_url('UserManagementController/detail/').$row['id_user'];?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>  
                              <a href="<?= base_url('UserManagementController/hapus/').$row['id_user'];?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>  
                          </td>
                        </tr>
                      <?php endforeach;?>
                      
                  </tbody>
              </table>
          </div>
      </div>
  </div>