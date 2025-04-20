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

 /* Modal Styles - Full Screen */
.modal-booking {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
    animation: fadeIn 0.3s;
}

.modal-content-booking {
    background-color: #fefefe;
    margin: 0;
    padding: 20px;
    border: none;
    width: 100%;
    height: 100%;
    border-radius: 0;
    box-shadow: none;
    display: flex;
    flex-direction: column;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Header Modal */
.modal-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Body Modal */
.modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}

/* Footer Modal */
.modal-footer {
    padding: 15px;
    border-top: 1px solid #eee;
    text-align: right;
}

/* Close Button */
.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.close:hover {
    color: #333;
    transform: rotate(90deg);
}

/* Time Slots Grid */
.time-slots {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.time-slot {
    padding: 15px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 16px;
}

.time-slot:hover {
    background: #e9ecef;
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.time-slot.selected {
    background: #007bff;
    color: white;
    border-color: #006fe6;
}

/* Submit Button */
.btn-submit-booking {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease;
}

/* Responsive Adjustments */
@media (min-width: 768px) {
    .modal-content-booking {
        width: 80%;
        height: 90%;
        margin: 5% auto;
        border-radius: 10px;
    }
    
    .time-slots {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
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
            <button class="btn btn-success btn-custom btn-service" 
                    data-id-layanan="<?= $dl['id_layanan'] ?>" 
                    data-kode-layanan="<?= $dl['kode'] ?>" 
                    data-nama-layanan="<?= $dl['nama'] ?>">
              <?= $dl['nama'] ?>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Booking Modal Full Screen -->
<div id="bookingModal" class="modal-booking">
  <div class="modal-content-booking">
    <div class="modal-header">
      <h3 class="text-center" id="modalServiceName">Pilih Waktu Booking</h3>
      <span class="close">&times;</span>
    </div>
    
    <div class="modal-body">
      <input type="hidden" id="selected_id_layanan">
      <input type="hidden" id="selected_kode_layanan">
      
      <div class="form-group">
        <label class="h5">Pilih Waktu Booking</label>
        <div id="timeSlotInfo" class="alert alert-info mb-3">
          <i class="fas fa-info-circle"></i> Silakan pilih slot waktu yang tersedia
        </div>
        <div class="time-slots" id="id_waktu_booking">
          <!-- Time slots will be generated here -->
        </div>
      </div>
    </div>
    
    <div class="modal-footer">
      <button class="btn btn-primary btn-submit-booking" id="btnSubmitBooking">
        <i class="fas fa-calendar-check"></i> Booking Sekarang
      </button>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Buka modal dengan animasi
    function openBookingModal() {
        $('#bookingModal').fadeIn(300);
        $('.modal-content-booking').css({
            'transform': 'scale(0.9)',
            'opacity': '0'
        }).animate({
            'transform': 'scale(1)',
            'opacity': '1'
        }, 300);
    }

    // Tutup modal dengan animasi
    function closeBookingModal() {
        $('.modal-content-booking').animate({
            'transform': 'scale(0.9)',
            'opacity': '0'
        }, 200, function() {
            $('#bookingModal').fadeOut(200);
        });
        selectedSlot = null;
    }

    // Buka modal saat tombol layanan diklik
    $(document).on('click', '.btn-service', function() {
        const id_layanan = $(this).data('id-layanan');
        const kode_layanan = $(this).data('kode-layanan');
        const nama_layanan = $(this).data('nama-layanan');
        
        current_id_layanan = id_layanan;
        $('#selected_id_layanan').val(id_layanan);
        $('#selected_kode_layanan').val(kode_layanan);
        $('#modalServiceName').text(nama_layanan + ' - Pilih Waktu Booking');
        
        // Tampilkan loading
        $('#id_waktu_booking').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-3">Memuat waktu tersedia...</p>
            </div>
        `);
        
        // Ambil waktu booking dari server
        $.ajax({
            url: '<?= site_url("UserController/get_waktu_booking") ?>',
            type: 'POST',
            dataType: 'json',
            data: { id_layanan: id_layanan },
            success: function(slots) {
                $('#id_waktu_booking').empty();
                
                if (slots.length === 0) {
                    $('#id_waktu_booking').html(`
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-circle"></i> Tidak ada slot waktu tersedia untuk layanan ini.
                        </div>
                    `);
                    return;
                }
                
                // Buat grid time slots
                $.each(slots, function(index, slot) {
                    const timeSlot = $(`
                        <div class="time-slot" data-slot-id="${slot.id}">
                            <h6 class="slot-time">${slot.waktu_awal}-${slot.waktu_akhir}</h6>
                            <div class="slot-info">
                                <span class="badge badge-success">Kuota: ${slot.kuota_tersedia}</span>
                            </div>
                        </div>
                    `).click(function() {
                        $('.time-slot').removeClass('selected');
                        $(this).addClass('selected');
                        selectedSlot = slot;
                        $('#timeSlotInfo').html(`
                            <i class="fas fa-check-circle"></i> Slot dipilih: <strong>${slot.waktu_awal}-${slot.waktu_akhir}</strong>
                        `).removeClass('alert-info').addClass('alert-success');
                    });
                    
                    $('#id_waktu_booking').append(timeSlot);
                });
            },
            error: function() {
                $('#id_waktu_booking').html(`
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-times-circle"></i> Gagal memuat waktu booking. Silakan coba lagi.
                    </div>
                `);
            }
        });
        
        openBookingModal();
    });

    // Tutup modal saat tombol close diklik
    $('.close').click(closeBookingModal);

    // Tutup modal saat klik di luar modal
    $(window).click(function(event) {
        if ($(event.target).is('#bookingModal')) {
            closeBookingModal();
        }
    });

    // Submit booking
    $('#btnSubmitBooking').click(function() {
        if (!selectedSlot) {
            showSweetAlert('warning', 'Peringatan', 'Harap pilih waktu booking terlebih dahulu');
            return;
        }
        
        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...').prop('disabled', true);
        
        $.ajax({
            url: '<?= site_url("UserController/simpan_booking") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_layanan: $('#selected_id_layanan').val(),
                kode_layanan: $('#selected_kode_layanan').val(),
                id_waktu_booking: selectedSlot.id
            },
            success: function(response) {
                btn.html('<i class="fas fa-calendar-check"></i> Booking Sekarang').prop('disabled', false);
                
                if (response.status == 'success') {
                    closeBookingModal();
                    showSweetAlert(response.status, response.message, '<?= site_url('HomeController'); ?>');
                    // showSweetAlert(
                    //     'success', 
                    //     'Booking Berhasil', 
                    //     'Nomor antrian Anda: ' + response.data.no_antrian,
                    //     'booking/detail/' + response.data.id_booking
                    // );
                } else {
                    showSweetAlert(response.status, response.message);
                    $('.btn-service[data-id-layanan="' + current_id_layanan + '"]').click();
                }
            },
            error: function() {
                btn.html('<i class="fas fa-calendar-check"></i> Booking Sekarang').prop('disabled', false);
                showSweetAlert('error', 'Terjadi kesalahansaat memproses booking');
            }
        });
    });
});
</script>