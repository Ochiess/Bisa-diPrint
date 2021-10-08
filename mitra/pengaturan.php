<?php

require('template/header.php');

$agen_id = $_SESSION['id_mitra'];
$success = false;

$row = lihat_profil($id);
$config = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$agen_id'");
$cfg = mysqli_fetch_assoc($config);
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-config icon-gradient bg-deep-blue"></i>
                </div>
                <div>Pengaturan</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan</h5>
            <hr>
            <div class="main-card mb-3 card border">
                <div class="card-header">Pengaturan Layanan</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <label><b>1. Layanan Cetak Dokumen</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="dokumen_aktif" name="cetak_dokumen" class="custom-control-input cetak_dokumen" value="1" <?= ($cfg['cetak_dokumen']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="dokumen_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="dokumen_nonaktif" name="cetak_dokumen" class="custom-control-input cetak_dokumen" value="0" <?= ($cfg['cetak_dokumen']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="dokumen_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label><b>2. Layanan Cetak Foto</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="foto_aktif" name="cetak_foto" class="custom-control-input cetak_foto" value="1" <?= ($cfg['cetak_foto']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="foto_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="foto_nonaktif" name="cetak_foto" class="custom-control-input cetak_foto" value="0" <?= ($cfg['cetak_foto']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="foto_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="main-card mb-3 card border">
                <div class="card-header">Metode Pembayaran</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label><b>Pembayaran Virtual</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="virtual_aktif" name="pembayaran_virtual" class="custom-control-input pembayaran_virtual" value="1" <?= ($cfg['pembayaran_virtual']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="virtual_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="virtual_nonaktif" name="pembayaran_virtual" class="custom-control-input pembayaran_virtual" value="0" <?= ($cfg['pembayaran_virtual']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="virtual_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card border">
                <div class="card-header">Profil Mitra</div>
                <div class="card-body">
                    <table class="mb-0 table table-bordered">
                        <tbody>
                            <tr>
                                <td>Foto Profil</td>
                                <td>
                                    <?php if ($row["poto"]) { ?>
                                        <img width="100" class="rounded-circle" src="img/daftar<?= $row['poto'] ?>" alt="" height="100">
                                    <?php } else { ?>
                                        <img width="100" class="rounded-circle" src="../user/img/default.png" alt="" height="100">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Percetakan</td>
                                <td><?= $row["nama_percetakan"];?></td>
                            </tr>
                            <tr>
                                <td>Nama Pemilik</td>
                                <td><?= $row["nama_pemilik"];?></td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td><?= $row["telpon"];?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $row["email"];?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?= $row["alamat"];?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="edit_profil.php?id=<?=$row["id"]; ?>" type="Submit" name="submit" class="mb-2 mt-2 btn btn-primary">Edit Profil</a>
                </div>
            </div>

            <div class="main-card mb-3 card border">
                <div class="card-header">Status Layanan</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label><b>Status Layanan</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="status_aktif" name="status" class="custom-control-input status_lyn" value="active" <?= ($row['status']=='active') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="status_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="status_nonaktif" name="status" class="custom-control-input status_lyn" value="0" <?= ($row['status']=='nonactive') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="status_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<script>
    $(document).ready(function() {
        $('#nv-settings').addClass('mm-active');


        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui',
                preConfirm: () => {
                    window.location.href='pengaturan.php';
                }
            });
        <?php } ?>
    });
</script>