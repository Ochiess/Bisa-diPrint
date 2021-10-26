<?php
require('template/header.php');

$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND (status != 'finish' AND status != 'cancel') ORDER BY id DESC");
?>
<!--main content-->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-print icon-gradient bg-deep-blue"></i>
                </div>
                <div>Data Pesanan Masuk</div>
            </div>
        </div>
    </div>

    <div class="mb-3 card">
        <div class="card-header">
            <ul class="nav nav-justified">
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_semua_pesanan" class="nav-link"><i class="fa fa-archive" style="font-size: 15px;"></i> Semua Pesanan</a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_antrian" class="nav-link show active" id="tab_antrian_link"><i class="fa fa-list-ol" style="font-size: 15px;"></i> Antrian Pesanan</a>
                    <small><span class="badge badge-pill badge-danger badgeReview" style="margin-bottom: 20px; padding: 5px 0 5px 0; margin-left: -35px;" hidden="">0</span></small>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_proses" class="nav-link" id="tab_proses_link"><i class="fa fa-hourglass-half" style="font-size: 15px;"></i> Sedang Diproses</a>
                    <small><span class="badge badge-pill badge-danger badgeProccess text-danger" style="margin-bottom: 20px; padding: 0px; margin-left: -50px; min-width: 8px;" hidden="">0</span></small>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_selesai" class="nav-link"><i class="fa fa-check-circle" style="font-size: 15px;"></i> Selesai Diproses</a>
                    <small><span class="badge badge-pill badge-danger badgeDone" style="margin-bottom: 20px; padding: 5px 0 5px 0; margin-left: -35px;" hidden="">0</span></small>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_belum_bayar" class="nav-link" id="tab_belum_bayar_link"><i class="fa fa-credit-card" style="font-size: 15px;"></i> Belum Dibayar</a>
                    <small><span class="badge badge-pill badge-danger badgePanding" style="margin-bottom: 20px; padding: 5px 0 5px 0; margin-left: -35px;" hidden="">0</span></small>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" id="tab_semua_pesanan" role="tabpanel">
                    <h5 class="card-title">Semua Pesanan</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="150">Nama Pelanggan</th>
                                <th width="90">Tipe File</th>
                                <th>Waktu Pemesanan</th>
                                <th>Permintaan Selesai</th>
                                <th>Harga</th>
                                <th width="120">Metode Bayar</th>
                                <th>Status</th>
                                <th width="70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataPesananAll">

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane show active" id="tab_antrian" role="tabpanel">
                    <h5 class="card-title">Data Antrian Pesanan</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="150">Nama Pelanggan</th>
                                <th width="90">Tipe File</th>
                                <th>Waktu Pemesanan</th>
                                <th>Permintaan Selesai</th>
                                <th width="150">Catatan</th>
                                <th width="90">File</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataPesananAntrian">

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab_proses" role="tabpanel">
                    <h5 class="card-title">Pesanan Sedang Diproses</h5>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="150">Nama Pelanggan</th>
                                <th width="90">Tipe File</th>
                                <th>Waktu Pemesanan</th>
                                <th>Permintaan Selesai</th>
                                <th width="150">Catatan</th>
                                <th width="100">File</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataPesananProses">

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab_selesai" role="tabpanel">
                    <h5 class="card-title">Pesanan Selesai Diproses</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="150">Nama Pelanggan</th>
                                <th>No Telpon</th>
                                <th width="90">Tipe File</th>
                                <th>Harga</th>
                                <th width="120">Metode Bayar</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataPesananSelesai">

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab_belum_bayar" role="tabpanel">
                    <h5 class="card-title">Pesanan Belum Dibayar</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="150">Nama Pelanggan</th>
                                <th>No Telpon</th>
                                <th width="90">Tipe File</th>
                                <th>Waktu Pemesanan</th>
                                <th>Permintaan Selesai</th>
                                <th>Harga</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dataPesananPanding">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('template/footer.php');
?>

<?php foreach ($pesanan as $dta) {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'")); 

    $text = '';
    if ($dta['status'] == 'panding') $text = 'text-warning';    
    else if ($dta['status'] == 'review') $text = 'text-info';    
    else if ($dta['status'] == 'proccess') $text = 'text-alternate';    
    else if ($dta['status'] == 'done') $text = 'text-success'; 

    if ($dta['jenis_layanan'] == 'dokumen') $file = '../assets/files/dokumen/'.$dta['file'];
    else $file = '../assets/files/foto/'.$dta['file']; ?>

    <!-- MODAL DETAIL PESANAN -->
    <div class="modal fade modal-detail<?= $dta['id'] ?>" role="dialog" style="z-index: 9999;">
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
                                <td width="200">Nama Pelanggan</td>
                                <td width="10">:</td>
                                <td><?= $user["nama_lengkap"] ?></td>
                            </tr>
                            <tr>
                                <td width="200">Telepon</td>
                                <td width="10">:</td>
                                <td><?= $user["hp"] ?></td>
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
                                <td width="200">Catatan Untuk Pencetak</td>
                                <td width="10">:</td>
                                <td><?= $dta['catatan'] ? $dta['catatan'] : '' ?></td>
                            </tr>
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

    <!-- MODAL PROSES PESANAN -->
    <div class="modal fade modal-proses<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proses Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Yakin ingin memproses pesanan? Silahkan kilk "Lanjutkan" untuk memproses pesanan ini.
                        <hr style="margin-top: 5px; margin-bottom: 5px;">
                        <small class="text-muted">Pastikn anda telah mendownload file dan melihat detail pesanan untuk menghindari kesalahan percetakan yang tidak diinginkan.</small>
                        <div class="text-center mt-2">
                            <a href="#" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target=".modal-detail<?= $dta['id'] ?>"><i class="fa fa-list"></i> Lihat Detail</a>
                            <a href="'<?= $file ?>'" class="btn btn-outline-primary btn-sm"><i class="fa fa-download"></i> Download File</a>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="#" role="button" class="btn btn-success proses" data-id="<?= $dta['id'] ?>" data-user="<?= $dta['user_id'] ?>">Lanjutkan</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nanti Dulu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL SELESAIKAN PESANAN -->
    <div class="modal fade modal-selesai<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selesaikan Pesanan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Silahkan kilk "Lanjutkan" untuk menyelesaikan pesanan ini.
                        <hr style="margin-top: 5px; margin-bottom: 5px;">
                        <small class="text-muted">Pastikn anda telah menyelesaikan pesanan sesuai detail pesanan sebelum melanjutkan.</small>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="#" role="button" class="btn btn-success selesai" data-id="<?= $dta['id'] ?>" data-user="<?= $dta['user_id'] ?>">Lanjutkan</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nanti Dulu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL TOLAK PESANAN -->
    <div class="modal fade modal-tolak<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pesanan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="tolak" data-id="<?= $dta['id'] ?>" data-user="<?= $dta['user_id'] ?>">
                    <div class="modal-body">
                        Yakin ingin menolah pesanan ini? Silahkan masukkan alasan penolakan anda pada form di bawah!
                        <textarea class="form-control my-2 pesan-tolak" required="" placeholder="Masukkan alasan penolakan..."></textarea>
                        <hr style="margin-top: 5px; margin-bottom: 5px;">
                        <small class="text-muted">Pesanan yang ditolak tidak bisa diproses lagi.</small>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-danger">Tolak Pesanan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Jadi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>

<script>
    $(document).ready(function() {
        <?php if (isset($_GET['virtual_pay'])) { ?>
            $('#tab_antrian_link').removeClass('active show');
            $('#tab_belum_bayar_link').addClass('active show');
            $('#tab_antrian').removeClass('active show');
            $('#tab_belum_bayar').addClass('active show');
        <?php } ?>

        $('#nv-pesanan').addClass('mm-active');

        var agen_id = '<?= $id ?>';

        getDataPesanan();
        function getDataPesanan() {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'getDataPesanan',
                    id: agen_id
                },
                success : function(data) {
                    $('#dataPesananAll').html(data.all);
                    $('#dataPesananAntrian').html(data.review);
                    $('#dataPesananProses').html(data.proccess);
                    $('#dataPesananSelesai').html(data.done);
                    $('#dataPesananPanding').html(data.panding);
                }
            });
            countPesanan();
        }

        $('.selesai').click(function(event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var agen_id = $(this).attr('data-user');
            updateStatus(id, 'done');
            createMessage(agen_id, 'order_done');
        });

        $('.proses').click(function(event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var agen_id = $(this).attr('data-user');
            updateStatus(id, 'proccess');
            createMessage(agen_id, 'order_start');
        });

        $('.tolak').submit(function(event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var agen_id = $(this).attr('data-user');
            updateStatus(id, 'cancel');

            var pesanTolak = $(this).find('.pesan-tolak').val();
            createMessage(agen_id, 'order_refuse', pesanTolak);
        });

        $(document).on('click', '.selesaikan', function(event) {
            event.preventDefault();
            var infoKode = $(this).attr('data-info');
            if (infoKode == 1) {
                var title = 'Selesaikan Pesanan Sebelumnya';
                var message = 'Terdapat pesanan yang belum selesai diproses. Selesaikan terlebih dahulu';
            } else {
                var title= 'Kerjakan Sesuai Antrian';
                var message= 'Harap memproses pengerjaan sesuai antrian!';
            }
            iziToast.warning({
                title: title,
                message: message,
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

                    if (status == 'proccess' || status == 'cancel') {
                        $('#tab_antrian_link').removeClass('active show');
                        $('#tab_proses_link').addClass('active show');
                        $('#tab_antrian').removeClass('active show');
                        $('#tab_proses').addClass('active show');
                    } else if(status == 'done') {
                        $('#tab_antrian_link').addClass('active show');
                        $('#tab_proses_link').removeClass('active show');
                        $('#tab_antrian').addClass('active show');
                        $('#tab_proses').removeClass('active show');
                    }

                    getDataPesanan();
                    $('.modal').hide();
                    $('body').removeClass('modal-open').removeAttr('style');
                    $('.modal-backdrop ').remove();
                }
            });            
        }
        messaging.onMessage((payload) => {
            getDataPesanan();
        });
    });

</script>