<?php

require('template/header.php');

$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND (status = 'finish' OR status = 'cancel') ORDER BY id DESC");
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-id icon-gradient bg-deep-blue"></i>
                </div>
                <div>Member Premium</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Member Premium</h5>
            <div>
                <h4 class="text-center mt-5 mb-5"><i>Anda belum menjadi member premium</i></h4>
            </div>
            <hr>
            <h5 class="text-center mt-3">Bayar Sekali Print berkali-kali</h5>
            <div class="text-center mb-5">
                Untuk menjadi member premium, silahkan melakukan top up di berbagai paket di bawah ini
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                    <h4 style="text-transform: uppercase">Paket Perdana</h4>
                        <h4 class="mt-2 text-success">Rp. 20.000 </h4>
                        <hr>
                        <button class="btn btn-primary mt-2">TOP UP</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                        <h4 style="text-transform: uppercase">Paket Medium</h4>
                        <h4 class="mt-2 text-success">Rp. 50.000 </h4>
                        <hr>
                        <button class="btn btn-warning mt-2">TOP UP</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                    <h4 style="text-transform: uppercase">Paket Super</h4>
                        <h4 class="mt-2 text-success">Rp.100.000 </h4>
                        <hr>
                        <button class="btn btn-danger mt-2">TOP UP</button>
                    </div>
                </div>
            </div>
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
    else if ($dta['status'] == 'finish') $text = 'text-success'; ?>

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
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-member').addClass('mm-active');
    });
</script>