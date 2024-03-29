<?php

require('template/header.php');

$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND (status = 'finish' OR status = 'cancel') ORDER BY id DESC");

if (isset($_POST['set_rating'])) {
    $rating = $_POST['rating'];
    $user_id = $_POST['user_id'];
    $agen_id = $_POST['agen_id'];

    $cek_rating = mysqli_query($conn, "SELECT * FROM rating WHERE user_id='$user_id' AND agen_id='$agen_id'");
    $myr = mysqli_fetch_assoc($cek_rating);
    if ($myr) {
        mysqli_query($conn, "UPDATE rating SET rating='$rating' WHERE user_id='$user_id'");
    } else {
        mysqli_query($conn, "INSERT INTO rating VALUES(NULL, '$user_id', '$agen_id', '$rating')");
    }

    $success_rat = true;
}
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-clock icon-gradient bg-deep-blue"></i>
                </div>
                <div>Riwayat Pesanan</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Data Riwayat Pesanan</h5>
            <hr>
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th width="10">No</th>
                        <th width="150">Tempat Cetak</th>
                        <th width="80">Tipe File</th>
                        <th>Waktu Pemesanan</th>
                        <th>Harga</th>
                        <th width="120">Metode Bayar</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($pesanan as $dta) {
                        $print = mysqli_query($conn, "SELECT * FROM agen WHERE id='" . $dta["agen_id"] . "'");
                        $prt = mysqli_fetch_assoc($print);
                        $badge = '';
                        if ($dta['status'] == 'cancel') $badge = 'badge-danger';
                        else if ($dta['status'] == 'finish') $badge = 'badge-success';

                        $bayar = [];
                        if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
                        else if ($dta['metode_pembayaran'] == 'member') $bayar = ['text-warning', 'Saldo Member'];
                        else $bayar = ['text-success', 'Pembayaran Virtual']; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $prt ? $prt["nama_percetakan"] : '<i>Tidak tersedia lagi</i>' ?></td>
                            <td><?= ucwords($dta['jenis_layanan']) ?></td>
                            <td class="text-center">
                                <span><?= date('d/m/Y', strtotime($dta['waktu_pesanan'])) ?></span> <b><?= date('H:i', strtotime($dta['waktu_pesanan'])) ?></b>
                            </td>
                            <td>Rp.<?= number_format($dta['harga']) ?></td>
                            <td class="text-center">
                                <span class="<?= $bayar[0] ?>" style="font-size: 12px;"><b><?= $bayar[1] ?></b></span>
                            </td>
                            <td>
                                <span class="badge <?= $badge ?> badge-pill"><?= $dta['status'] ?></span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white" style="font-size: 12px;" data-toggle="modal" data-target="#modal-rating<?= $dta['id'] ?>"><i class="fa fa-star"></i> Rating</button>
                                <button class="btn btn-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modal-detail<?= $dta['id'] ?>"><i class="fa fa-list"></i> Detail</button>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<?php foreach ($pesanan as $dta) {
    $print = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM agen WHERE id='" . $dta["agen_id"] . "'"));

    $text = '';
    if ($dta['status'] == 'cancel') $text = 'text-danger';
    else if ($dta['status'] == 'finish') $text = 'text-success';

    $agen_id = $dta['agen_id'];
    $my_rating = mysqli_query($conn, "SELECT * FROM rating WHERE user_id='$id' AND agen_id='$agen_id'");
    $myr = mysqli_fetch_assoc($my_rating);
    $my_rat = 0;
    if ($myr) {
        $my_rat = $myr['rating'];
    }
?>

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
                                $dokumen = mysqli_query($conn, "SELECT * FROM cetak_dokumen WHERE cetak_id='" . $dta['id'] . "'");
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
                                    <td><?= $dkm ? $dkm["jumlah_halaman"] . ' Lembar' : '-' ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Jumlah Rangkap</td>
                                    <td width="10">:</td>
                                    <td><?= $dkm ? $dkm["jumlah_rangkap"] . ' Rangkap' : '-' ?></td>
                                </tr>
                            <?php } else {
                                $foto = mysqli_query($conn, "SELECT * FROM cetak_foto WHERE cetak_id='" . $dta['id'] . "'");
                                $fto = mysqli_fetch_assoc($foto);
                                $ukf_id = $fto ? $fto['ukuran_foto'] : 0;
                                $ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE id='$ukf_id'");
                                $ukf = mysqli_fetch_assoc($ukuran_foto); ?>
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
                                    <td><?= $fto ? $fto["jumlah_rangkap"] . ' Lembar' : '-' ?></td>
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
                                <td>
                                    <?php
                                    if ($dta['metode_pembayaran'] == 'langsung') echo 'Bayar Langsung';
                                    else if ($dta['metode_pembayaran'] == 'member') echo 'Saldo Member';
                                    else echo 'Pembayaran Virtual';
                                    ?>
                                </td>
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

    <!-- Modal Rating -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-rating<?= $dta['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Berikan Penilaian Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form method="post" class="set-rating">
                        <span>Silahkan berikan penilaian untuk <b><?= $print ? $print['nama_percetakan'] : '' ?></b></span>
                        <hr>
                        <div class="mt-4 mb-4">
                            <?php for ($i = 1; $i <= $my_rat; $i++) { ?>
                                <a href="#"><i class="rat rat-<?= $i ?> fa fa-star fa-4x text-warning" data-rat="<?= $i ?>"></i></a>
                            <?php } ?>

                            <?php for ($i = $my_rat + 1; $i <= 5; $i++) { ?>
                                <a href="#"><i class="rat rat-<?= $i ?> fa fa-star fa-4x text-light" data-rat="<?= $i ?>"></i></a>
                            <?php } ?>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" name="rating" class="val-rating">
                            <input type="hidden" name="user_id" value="<?= $id ?>">
                            <input type="hidden" name="agen_id" value="<?= $dta['agen_id'] ?>">
                            <button type="submit" name="set_rating" class="btn btn-success btn-lg"><i class="fa fa-paper-plane"></i> Kirim Rating</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-riwayat').addClass('mm-active');

        $('.rat').click(function(e) {
            e.preventDefault();

            var this_rat = $(this).attr('data-rat');
            $(this).parents('.set-rating').find('.rat').removeClass('text-warning').addClass('text-light');
            $(this).parents('.set-rating').find('.val-rating').val(this_rat);
            for (let i = 1; i <= this_rat; i++) {
                $(this).parents('.set-rating').find('.rat-' + i).removeClass('text-light').addClass('text-warning');
            }
        });

        <?php if (isset($success_rat)) { ?>
            iziToast.success({
                title: "Penilaian Terkirim",
                message: "Terima kasih telah memberikan penilaian untuk mitra kami!",
                position: 'topRight'
            });
        <?php } ?>
    });
</script>