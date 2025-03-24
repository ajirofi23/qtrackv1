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
                          <th>No. Antrian</th>
                          <th>Layanan</th>
                          <th>Tanggal Booking</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Data akan diisi oleh DataTables -->
                      <tr>
                          <td>001</td>
                          <td>Layanan A</td>
                          <td>2023-10-10 10:00:00</td>
                          <td><span class="badge badge-success">Selesai</span></td>
                          <td>
                              <button class="btn btn-sm btn-info">Detail</button>
                          </td>
                      </tr>
                      <tr>
                          <td>002</td>
                          <td>Layanan B</td>
                          <td>2023-10-10 10:05:00</td>
                          <td><span class="badge badge-warning">Menunggu</span></td>
                          <td>
                              <button class="btn btn-sm btn-info">Detail</button>
                          </td>
                      </tr>
                      <tr>
                          <td>003</td>
                          <td>Layanan C</td>
                          <td>2023-10-10 10:10:00</td>
                          <td><span class="badge badge-danger">Dibatalkan</span></td>
                          <td>
                              <button class="btn btn-sm btn-info">Detail</button>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>