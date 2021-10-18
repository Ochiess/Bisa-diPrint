<?php

require('template/header.php');

$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND (status != 'finish' AND status != 'cancel')");
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-paperclip icon-gradient bg-deep-blue"></i>
                </div>
                <div>Pesanan Saya</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Data Pesanan</h5>
            <hr>
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th width="150">Tempat Cetak</th>
                        <th width="80">Tipe File</th>
                        <th>Waktu Pemesanan</th>
                        <th>Permintaan Selesai</th>
                        <th>Harga</th>
                        <th width="120">Metode Bayar</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataPesanan">

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<?php foreach ($pesanan as $dta) {
    $print = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM agen WHERE id='".$dta["agen_id"]."'")); 

    $text = '';
    if ($dta['status'] == 'panding') $text = 'text-warning';    
    else if ($dta['status'] == 'review') $text = 'text-info';    
    else if ($dta['status'] == 'proccess') $text = 'text-alternate';    
    else if ($dta['status'] == 'done') $text = 'text-success'; ?>

    <!-- MODAL DETAIL PESANAN -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-detail<?= $dta['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detil Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="200">Tempat Cetak</td>
                                <td width="10">:</td>
                                <td><?= $print["nama_percetakan"] ?></td>
                            </tr>
                            <tr>
                                <td width="200">Alamat</td>
                                <td width="10">:</td>
                                <td><?= $print["alamat"] ?></td>
                            </tr>
                            <tr>
                                <td width="200">Telepon</td>
                                <td width="10">:</td>
                                <td><?= $print["telpon"] ?></td>
                            </tr>                              
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="200">Jenis Layanan</td>
                                <td width="10">:</td>
                                <td>Cetak <?= ucwords($dta["jenis_layanan"]) ?></td>
                            </tr>
                            <?php if ($dta["jenis_layanan"] == 'dokumen') { 
                                $dokumen = mysqli_query($conn, "SELECT * FROM cetak_dokumen WHERE cetak_id='".$dta['id']."'");
                                $dkm = mysqli_fetch_assoc($dokumen);
                                $jnk_id = $dkm ? $dkm['jenis_kertas'] : 0;
                                $jld_id = $dkm ? $dkm['jilid'] : 0;
                                $jenis_kertas = mysqli_query($conn, "SELECT * FROM jenis_kertas WHERE id='$jnk_id'");
                                $jilid = mysqli_query($conn, "SELECT * FROM jilid WHERE id='$jld_id'");
                                $jnk = mysqli_fetch_assoc($jenis_kertas);
                                $jld = mysqli_fetch_assoc($jilid);
                                ?>
                                <tr>
                                    <td width="200">Warna Tulisan</td>
                                    <td width="10">:</td>
                                    <td><?= $dkm ? $dkm["warna_tulisan"] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jenis Kertas</td>
                                    <td width="10">:</td>
                                    <td><?= $jnk ? $jnk["jenis_kertas"] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jilid</td>
                                    <td width="10">:</td>
                                    <td><?= $jld ? $jld["item"] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jumlah Halaman</td>
                                    <td width="10">:</td>
                                    <td><?= $dkm ? $dkm["jumlah_halaman"].' Lembar' : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jumlah Rangkap</td>
                                    <td width="10">:</td>
                                    <td><?= $dkm ? $dkm["jumlah_rangkap"].' Rangkap' : '-' ?></td>
                                </tr>
                            <?php } else { 
                                $foto = mysqli_query($conn, "SELECT * FROM cetak_foto WHERE cetak_id='".$dta['id']."'");
                                $fto = mysqli_fetch_assoc($foto); 
                                $ukf_id = $fto ? $fto['ukuran_foto'] : 0;
                                $ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE id='$ukf_id'");
                                $ukf = mysqli_fetch_assoc($ukuran_foto);?>
                                <tr>
                                    <td width="200">Ukuran Foto</td>
                                    <td width="10">:</td>
                                    <td><?= $ukf ? $ukf["ukuran"] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Ganti Latar</td>
                                    <td width="10">:</td>
                                    <td><?= $fto ? $fto["ganti_latar"] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jumlah Rangkap</td>
                                    <td width="10">:</td>
                                    <td><?= $fto ? $fto["jumlah_rangkap"].' Lembar' : '-' ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="200">Waktu Pesanan</td>
                                <td width="10">:</td>
                                <td><?= date('d/m/Y H:i', strtotime($dta['waktu_pesanan'])) ?></td>
                            </tr>
                            <tr>
                                <td width="200">Permintan Waktu Selesai</td>
                                <td width="10">:</td>
                                <td><?= date('d/m/Y H:i', strtotime($dta['waktu_pengambilan'])) ?></td>
                            </tr>
                            <tr>
                                <td width="200">Catatan Untuk Pencetak</td>
                                <td width="10">:</td>
                                <td><?= $dta['catatan'] ? $dta['catatan'] : '' ?></td>
                            </tr>
                            <tr>
                                <td width="200">Harga</td>
                                <td width="10">:</td>
                                <td>Rp.<?= number_format($dta["harga"]) ?></td>
                            </tr>
                            <tr>
                                <td width="200">Metode Pembayaran</td>
                                <td width="10">:</td>
                                <td><?= ($dta["metode_pembayaran"] == 'virtual') ? 'Pembayaran Virtual' : 'Bayar Langsung' ?></td>
                            </tr>
                            <tr>
                                <td width="200">Status</td>
                                <td width="10">:</td>
                                <td class="<?= $text ?>"><b><?= ucwords($dta["status"]) ?></b></td>
                            </tr>                      
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BATALKAN PESANAN -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-batal<?= $dta['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Pesanan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Yakin ingin membatalkan pesanan ini? Silahkan klik "Lanjutkan" unutk membatalkan!<br>
                        <hr style="margin-top: 5px; margin-bottom: 5px;">
                        <small class="text-muted">Jika anda menggunakan metode pembayaran virtual, kami akan mengembalikan pembayaran anda dalam 1x24 jam</small>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="#" role="button" class="btn btn-danger batalkan" data-id="<?= $dta['id'] ?>">Lanjutkan</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Jadi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL AMBIL PESANAN -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-ambil<?= $dta['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengambilan Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Pastikan anda telah mengambil dan mengecek pesanan anda sebelum mengkonfirmasi pengambilan pesanan!
                        <hr style="margin-top: 5px; margin-bottom: 5px;">
                        <small class="text-muted">Jika anda menggunakan metode pembayaran virtual, setelah proses ini pembayaran tidak dapat dikembalikan lagi dan akan dikirim ke percetakan ini</small>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="#" role="button" class="btn btn-success selesaikan" data-id="<?= $dta['id'] ?>">Selesaikan</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nanti Dulu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-DAbmO3EFyeXaOTdB"></script>
<script>
    $(document).ready(function() {
        $('#nv-datapesanana').addClass('mm-active');

        var user_id = '<?= $id ?>';

        getDataPesanan();

        function getDataPesanan() {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'getDataPesanan',
                    id: user_id
                },
                success : function(data) {
                    $('#dataPesanan').html(data);
                }
            });
            countPesanan();
        }

        $('.batalkan').click(function(event) {
            var id = $(this).attr('data-id');
            updateStatus(id, 'cancel');
        });

        $('.selesaikan').click(function(event) {
            var id = $(this).attr('data-id');
            updateStatus(id, 'finish');
        });

        $(document).on('click', '.bayar', function(event) {
            var id = $(this).attr('data-id');
            var token = $(this).attr('data-token');
            var kode = $(this).attr('data-kode');

            snap.pay(token, {
                onSuccess: function(result){
                    cekStatusPayment(id, kode);
                },
                onPending: function(result){
                    cekStatusPayment(id, kode);
                },
                onError: function(result){
                    cekStatusPayment(id, kode);
                },
                onClose: function(result){
                    cekStatusPayment(id, kode);
                }
            });
        });

        $(document).on('click', '.btn-disabled', function(event) {
            event.preventDefault();
            iziToast.warning({
                title: "Sedang diproses",
                message: "Maaf, anda tidak dapat membatalkan pesanan ini!",
                position: 'topRight'
            });
        });

        function updateStatus(id, status) {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'updateStatus',
                    status: status,
                    id: id,
                },
                success : function(data) {
                    iziToast.success({
                        title: data.status,
                        message: data.message,
                        position: 'topRight'
                    });
                    getDataPesanan();
                    $('.modal').hide();
                    $('body').removeClass('modal-open').removeAttr('style');
                    $('.modal-backdrop ').remove();
                }
            });            
        }

        function cekStatusPayment(id, kode) {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'cekStatusPayment',
                    kode: kode,
                },
                success : function(data) {
                    if (data.transaction_status == "settlement" || data.transaction_status == "capture") {
                        updateStatus(id, 'review');
                    } else {
                        iziToast.info({
                            title: "Selesaikan pembayaran",
                            message: "Silahkan selesaikan pembayaran anda. Pesanan akan dibatalkan jika pembayaran tidak dilakuka dalam 1 jam",
                            position: 'topRight'
                        });
                    }
                }
            });
        }
    });
</script>