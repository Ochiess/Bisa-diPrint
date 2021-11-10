<?php
require('template/header.php');

$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND (status = 'finish' OR status = 'cancel') ORDER BY id DESC");
$get_pelanggan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id'");
$pelanggan = [];
foreach ($get_pelanggan as $dta) {  
    $pelanggan[] = $dta["user_id"];
}
?>
<!--main content-->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-clock icon-gradient bg-deep-blue"></i>
                </div>
                <div>Riwayat Pesanan & Data Pelanggan</div>
            </div>
        </div>
    </div>

    <div class="mb-3 card">
        <div class="card-header">
            <ul class="nav nav-justified">
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_riwayat_pesanan" class="nav-link show active"><i class="fa fa-clock" style="font-size: 15px;"></i> Riwayat Pesanan</a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#tab_data_pelanggan" class="nav-link"><i class="fa fa-users" style="font-size: 15px;"></i> Data Pelanggan</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane show active" id="tab_riwayat_pesanan" role="tabpanel">
                    <h5 class="card-title">Data Riwayat Pesanan</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="150">Nama Pelanggan</th>
                                <th width="80">Tipe File</th>
                                <th>Waktu Pemesanan</th>
                                <th>Harga</th>
                                <th width="120">Metode Bayar</th>
                                <th>Status</th>
                                <th width="70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=1;
                            foreach ($pesanan as $dta) {
                                $user = mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'");
                                $usr = mysqli_fetch_assoc($user);
                                $badge = '';
                                if ($dta['status'] == 'cancel') $badge = 'badge-danger';
                                else if ($dta['status'] == 'finish') $badge = 'badge-success';

                                $bayar = [];
                                if ($dta['metode_pembayaran'] == 'langsung') $bayar = ['text-primary', 'Bayar Langsung'];
                                else if ($dta['metode_pembayaran'] == 'member') $bayar = ['text-warning', 'Saldo Member'];
                                else $bayar = ['text-success', 'Pembayaran Virtual']; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $usr ? $usr["nama_lengkap"] : '<i>Tidak diketahui</i>' ?></td>
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
                                        <button class="btn btn-outline-info btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modal-detail<?= $dta['id'] ?>"><i class="fa fa-list"></i> Detail</button>
                                    </td>
                                </tr>
                                <?php 
                                $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab_data_pelanggan" role="tabpanel">
                    <h5 class="card-title">Data Riwayat Pesanan</h5>
                    <hr>
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th width="50">Foto</th>
                                <th>Nama Pelanggan</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th width="100">Status Member</th>
                                <th width="10">Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=1;
                            foreach (array_unique($pelanggan) as $usr_id) {
                                $user = mysqli_query($conn, "SELECT * FROM user WHERE id='$usr_id'");
                                $usr = mysqli_fetch_assoc($user); 
                                $member = mysqli_query($conn, "SELECT * FROM member WHERE user_id='$usr_id'"); ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td>
                                        <?php if ($usr["photo"]) { ?>
                                            <img width="60" class="rounded-circle" src="../user/img/<?= $usr['photo'] ?>" alt="" height="60">
                                        <?php } else { ?>
                                            <img width="60" class="rounded-circle" src="../user/img/default.png" alt="" height="60">
                                        <?php } ?>
                                    </td>
                                    <td><?= $usr ? $usr["nama_lengkap"] : '<i>Tidak diketahui</i>' ?></td>
                                    <td><?= $usr ? $usr["hp"] : '<i>Tidak diketahui</i>' ?></td>
                                    <td><?= $usr ? $usr["email"] : '<i>Tidak diketahui</i>' ?></td>
                                    <td>
                                        <?php 
                                        if (mysqli_num_rows($member) > 0) 
                                            echo '<span class="text-success">Member Premium</span>';
                                        else
                                            echo '<span class="text-warning">Member Biasa</span>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-success"><i class="fa fa-comment"></i> Chat</a>
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
    </div>
</div>
<?php
require('template/footer.php');
?>

<?php foreach ($pesanan as $dta) {
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='".$dta["user_id"]."'")); 

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
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-riwayat').addClass('mm-active');
    });
</script>