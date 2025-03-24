<style>
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
        padding: 15px; /* Tambahkan padding untuk header */
    }

    .custom-card-footer {
        background: #f8f9fa;
        border-radius: 0 0 15px 15px;
        padding: 10px; /* Tambahkan padding untuk footer */
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table th, .table td {
        text-align: center;
    }
</style>

<div class="row justify-content-center mt-5">
    <?php foreach ($data_loket as $row) : ?>
    <div class="col-md-4 mb-4">
        <div class="card custom-card" id="loket-antrian-<?= $row['id_layanan']; ?>" data-id-loket="<?= $row['id_loket'];?>" data-id-layanan="<?= $row['id_layanan']; ?>">
            <div class="card-header custom-card-header bg-primary text-center">
                <h4 class="text-uppercase text-center" id="jenis_layanan_<?=$row['id_loket'];?>"><?= $row['nama']; ?></h4>
                <span class="badge badge-<?= ($row['jenis'] == '1') ? 'success' : 'danger';?> text-center"><?= ($row['jenis'] == '1') ? 'BOOKING' : 'NON BOOKING';?></span>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">Antrian</h5>
                <p class="display-4" id="nomor_antrian_<?=$row['id_loket'];?>"></p>
                <span class="badge text-center" id="status_antrian"></span>
            </div>
            <div class="card-footer custom-card-footer text-center">
                <button class="btn btn-sm btn-danger mt-2" id="btn-<?=$row['id_loket'];?>" data-id-antrian="">Batal</button>
                <button class="btn btn-sm btn-success mt-2" id="btn-<?=$row['id_loket'];?>" data-id-antrian="">Panggil</button>
                <button class="btn btn-sm btn-secondary mt-2" id="btn-<?= $row['id_loket']; ?>" data-id-antrian="">Ulang</button>
                <button class="btn btn-sm btn-info mt-2" id="btn-<?=$row['id_loket'];?>" data-id-antrian="">Dilayani</button>
                <button class="btn btn-sm btn-warning mt-2" id="btn-<?=$row['id_loket'];?>" data-id-antrian="">Selesai</button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Tabel Daftar Antrian Hari Ini -->
<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="text-uppercase text-center">Daftar Antrian Hari Ini</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="daftar-antrian-hari-ini" class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Antrian</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Waktu Buat</th>
                            </tr>
                        </thead>
                        <tbody >
                            <!-- Data antrian akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let currentUtterance = null; // Variabel untuk menyimpan objek SpeechSynthesisUtterance yang sedang berjalan

    // Fungsi untuk membaca teks dengan suara
    function speak(text) {
        if ('speechSynthesis' in window) {
            // Hentikan suara yang sedang berjalan (jika ada)
            if (currentUtterance) {
                window.speechSynthesis.cancel();
            }

            // Buat objek SpeechSynthesisUtterance baru
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID'; // Set bahasa ke Indonesia
            utterance.rate = 1; // Kecepatan bicara (1 = normal)
            utterance.pitch = 1; // Tinggi nada (1 = normal)

            // Simpan objek utterance ke variabel global
            currentUtterance = utterance;

            // Mulai berbicara
            window.speechSynthesis.speak(utterance);
        } else {
            console.error('Browser tidak mendukung Web Speech API');
        }
    }

    // Fungsi untuk memanggil antrian
    function panggilAntrian(id_loket, id_antrian) {
        $.ajax({
            url: '<?= base_url("AntrianController/update_status_antrian"); ?>',
            method: 'POST',
            data: {
                id_antrian: id_antrian,
                status: 'panggil', // Status panggil
                id_loket: id_loket
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Ambil nomor antrian dan jenis layanan
                    var nomorAntrian = $('#nomor_antrian_' + id_loket).text();
                    var jenisLayanan = $('#jenis_layanan_' + id_loket).text();

                    // Buat teks untuk diucapkan
                    var textToSpeak = `Nomor antrian ${nomorAntrian}, silakan menuju loket ${id_loket}, untuk layanan ${jenisLayanan}.`;

                    // Baca teks menggunakan Web Speech API
                    speak(textToSpeak);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Antrian berhasil dipanggil'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memanggil antrian: ' + response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memanggil antrian.'
                });
            }
        });
    }

    // Fungsi untuk mengulang panggilan antrian
    function ulangPanggilan(id_loket) {
        // Ambil nomor antrian dan jenis layanan
        var nomorAntrian = $('#nomor_antrian_' + id_loket).text();
        var jenisLayanan = $('#jenis_layanan_' + id_loket).text();

        // Buat teks untuk diucapkan
        var textToSpeak = `Nomor antrian ${nomorAntrian}, silakan menuju loket ${jenisLayanan}.`;

        // Baca teks menggunakan Web Speech API
        speak(textToSpeak);
    }

    // Fungsi untuk mengupdate status antrian
    function updateStatusAntrian(id_loket, id_antrian, status) {
        $.ajax({
            url: '<?= base_url("AntrianController/update_status_antrian"); ?>',
            method: 'POST',
            data: {
                id_loket: id_loket,
                id_antrian: id_antrian,
                status: status // Status: proses, selesai, batal
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Status antrian berhasil diupdate'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengupdate status antrian: ' + response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengupdate status antrian.'
                });
            }
        });
    }

    
    // Set interval untuk mengambil data antrian setiap 1 detik
    setInterval(function() {
        $('.custom-card').each(function() {
            var id_loket = $(this).data('id-loket'); // Ambil id_loket dari data attribute
            var id_layanan = $(this).data('id-layanan'); // Ambil id_layanan dari data attribute
            var $display = $(this).find('.display-4'); // Temukan elemen untuk menampilkan nomor antrian
            var $status_antrian = $(this).find('#status_antrian'); // Temukan elemen untuk menampilkan status antrian
            $.ajax({
                url: '<?= base_url("AntrianController/get_antrian");?>', // Ganti dengan path ke file PHP Anda
                method: 'POST',
                data: { id_layanan: id_layanan, id_loket: id_loket }, // Kirim id_layanan dan id_loket sebagai parameter
                dataType: 'json',
                success: function(data) {
                    // Memeriksa apakah data yang diterima tidak kosong
                    if (data.length > 0) {
                        // Mengambil semua nomor antrian dan status antrian dari data
                        var nomor_antrian = data.map(function(item) {
                            return item.no_antrian; // Mengambil nomor antrian dari setiap objek
                        }).join(', '); // Menggabungkan nomor antrian menjadi string

                        var kode_layanan = data.map(function(item) {
                            return item.kode_layanan; // Mengambil kode layanan dari setiap objek
                        }).join(', '); // Menggabungkan kode layanan menjadi string

                        var status_antrian = data.map(function(item) {
                            return item.status_antrian; // Mengambil status antrian dari setiap objek
                        });
                        var id_antrians = data.map(function(item) {
                            return item.id; // Mengambil id antrian dari setiap objek
                        });

                        $('[id^="btn-' + id_loket + '"]').attr('data-id-antrian', id_antrians);
                        
                        // Inisialisasi variabel sa dan badge_color
                        var sa;
                        var badge_color;

                        // Memeriksa status antrian
                        if (status_antrian.every(function(status) { return status === 'buat'; })) {
                            sa = 'menunggu';
                            badge_color = 'badge-secondary';
                        } else if (status_antrian.some(function(status) { return status === 'panggil'; })) {
                            sa = 'Sedang Memanggil';
                            badge_color = 'badge-success';
                        } else if (status_antrian.some(function(status) { return status === 'proses'; })) {
                            sa = 'Sedang Melayani';
                            badge_color = 'badge-info';
                        } else if (status_antrian.some(function(status) { return status === 'selesai'; })) {
                            sa = 'Antrian Selesai';
                            badge_color = 'badge-warning';
                        } else {
                            sa = 'Antrian dibatalkan'; // Status lain yang tidak terduga
                            badge_color = 'badge-danger';
                        }

                        // Memperbarui tampilan
                        $display.text(kode_layanan + nomor_antrian); // Memperbarui nomor antrian di dalam elemen
                        $status_antrian.text(sa); // Memperbarui status antrian di dalam elemen
                        $status_antrian.removeClass().addClass('badge ' + badge_color); // Mengatur kelas badge
                        // Memperbarui data-id-antrian pada semua tombol
                       

                    } else {
                        $display.text('0'); // Menampilkan pesan jika tidak ada antrian
                        $status_antrian.text('Tidak ada antrian'); // Memperbarui status antrian di dalam elemen
                        $status_antrian.removeClass().addClass('badge badge-danger'); // Mengatur kelas badge

                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    }, 1000); // 1000 ms = 1 detik

    // Event listener untuk tombol
    $('[id^="btn-"]').on('click', function() {
        var id_loket = $(this).closest('.card').data('id-loket');
        var id_antrian = $(this).data('id-antrian');
        var action = $(this).text().toLowerCase(); // Ambil aksi dari teks tombol

        if (action === 'panggil') {
            panggilAntrian(id_loket, id_antrian);
        } else if (action === 'dilayani') {
            updateStatusAntrian(id_loket, id_antrian, 'proses');
        } else if (action === 'selesai') {
            updateStatusAntrian(id_loket, id_antrian, 'selesai');
        } else if (action === 'batal') {
            updateStatusAntrian(id_loket, id_antrian, 'batal');
        } else if (action === 'ulang') {
            ulangPanggilan(id_loket);
        }
    });

    // // Memuat daftar antrian hari ini saat halaman dimuat
    // loadDaftarAntrianHariIni();

    // Fungsi untuk mendapatkan warna badge berdasarkan status
    function getBadgeColor(status) {
        switch (status) {
            case 'buat':
                return 'secondary';
            case 'panggil':
                return 'success';
            case 'proses':
                return 'info';
            case 'selesai':
                return 'warning';
            case 'batal':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    // Inisialisasi DataTables
    var table = $('#daftar-antrian-hari-ini').DataTable({
        ajax: {
            url: '<?= base_url("AntrianController/get_daftar_antrian_hari_ini"); ?>',
            type: 'GET',
            dataSrc: '' // Jika data langsung berupa array, biarkan kosong
        },
        columns: [
            { data: 'no_antrian', title: 'No. Antrian' },
            { data: 'nama_layanan', title: 'Layanan' },
            { 
                data: 'status', 
                title: 'Status',
                render: function(data, type, row) {
                    var badgeColor = getBadgeColor(data);
                    return `<span class="badge badge-${badgeColor}">${data}</span>`;
                }
            },
            { data: 'waktu_buat', title: 'Waktu Buat' }
        ],
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });

    // Fungsi untuk memperbarui data tabel setiap 1 detik
    function reloadTable() {
        console.log("Memperbarui tabel...");
        table.ajax.reload(null, false); // false untuk mempertahankan paging
    }

    // Set interval untuk memanggil fungsi reloadTable setiap 1 detik
    setInterval(reloadTable, 1000);
    
});

</script>