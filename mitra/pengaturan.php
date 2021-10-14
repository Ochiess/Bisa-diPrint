<?php

require('template/header.php');

$agen_id = $_SESSION['id_mitra'];
$success = false;

if (isset($_GET['update_status'])) {
    $setting_agen = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$agen_id'");
    $set = mysqli_fetch_assoc($setting_agen);
    $pembayaran_virtual = isset($_GET['pembayaran_virtual']) ? $_GET['pembayaran_virtual'] : $set['pembayaran_virtual'];
    $pembayaran_langsung = isset($_GET['pembayaran_langsung']) ? $_GET['pembayaran_langsung'] : $set['pembayaran_langsung'];
    $cetak_dokumen = isset($_GET['cetak_dokumen']) ? $_GET['cetak_dokumen'] : $set['cetak_dokumen'];
    $cetak_foto = isset($_GET['cetak_foto']) ? $_GET['cetak_foto'] : $set['cetak_foto'];

    mysqli_query($conn, "UPDATE setting_agen SET pembayaran_virtual='$pembayaran_virtual', pembayaran_langsung='$pembayaran_langsung', cetak_dokumen='$cetak_dokumen', cetak_foto='$cetak_foto' WHERE agen_id='$agen_id'");
    $success = true;
}

if (isset($_GET['status_layanan'])) {
    $value = $_GET['value'];
    $cek_pengerjaan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$agen_id' AND (status != 'finish' AND status != 'cancel')");
    if (mysqli_num_rows($cek_pengerjaan) < 0) {
        mysqli_query($conn, "UPDATE agen SET status='$value' WHERE id='$agen_id'");
        $success = true;
    } else {
        $antrian = true;
    }
}

if (isset($_POST['set_rekening'])) {
    $rekening = $_POST['rekening'];
    $no_rekening = $_POST['no_rekening'];
    mysqli_query($conn, "UPDATE setting_agen SET rekening='$rekening', no_rekening='$no_rekening' WHERE agen_id='$agen_id'");
    $success = true;
}

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
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <label><b>Pembayaran Langsung</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="langsung_aktif" name="pembayaran_langsung" class="custom-control-input pembayaran_langsung" value="1" <?= ($cfg['pembayaran_langsung']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="langsung_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="langsung_nonaktif" name="pembayaran_langsung" class="custom-control-input pembayaran_langsung" value="0" <?= ($cfg['pembayaran_langsung']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="langsung_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
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

                    <?php if ($cfg['pembayaran_virtual']==1) { ?>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <label><b>Atur Rekening Penarikan Dana</b></label>
                                <div class="mb-2 text-justify">
                                    <small class="text-muted">Jika anda mengaktifkan metode pembayaran virtual, anda diharuskan megisi data rekening penarikan dana. kami akan mengirimkan dana ke rekening yang anda atur dibawah apabila anda ingin melakukan penarikan dana dari sistem. Pastikan anda megisi data yang valid</small>
                                </div>
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Jenis Rekening</label>
                                        <?php
                                        $bank = ["Bank BRI", "Bank BNI", "Bank Syariah", "GoPay", "Dana", "OVO"]; 
                                        ?>
                                        <select class="form-control" name="rekening" required="">
                                            <option value="">.::Pilih Rekening::.</option>
                                            <?php foreach ($bank as $bnk) { ?>
                                                <option value="<?= $bnk ?>" <?php if ($bnk == $cfg['rekening']) echo 'selected' ?>><?= $bnk ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Rekening</label>
                                        <input type="text" name="no_rekening" class="form-control" placeholder="Nomor Rekening.." value="<?= $cfg['no_rekening'] ?>" required="" autocomplete="off">
                                    </div>
                                    <button class="btn btn-primary btn-sm" type="submit" name="set_rekening"><i class="fa fa-save"></i> Simpan Pembaruan</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
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
                                <input type="radio" id="status_nonaktif" name="status" class="custom-control-input status_lyn" value="nonactive" <?= ($row['status']=='nonactive') ? 'checked' : '' ?>>
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

        $('.cetak_dokumen').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#dokumen_nonaktif').prop('checked', true);
                var title = 'Aktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan layanan Cetak Dokumen!';
            } else {
                $('#dokumen_aktif').prop('checked', true);
                if ($("input[name='cetak_foto']:checked").val() == '0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak dapat diproses',
                        text: 'Salah satu layanan harus aktif',
                    });
                    return;
                } else {
                    var title = 'Nonaktifkan Layanan?';
                    var text = 'Klik "Lanjutkan" untuk menonaktifkan layanan Cetak Dokumen!';
                }
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='pengaturan.php?update_status=true&cetak_dokumen='+val;
                }
            });
        });

        $('.cetak_foto').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#foto_nonaktif').prop('checked', true);
                var title = 'Aktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan layanan Cetak Foto!';
            } else {
                $('#foto_aktif').prop('checked', true);
                if ($("input[name='cetak_dokumen']:checked").val() == '0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak dapat diproses',
                        text: 'Salah satu layanan harus aktif',
                    });
                    return;
                } else {
                    var title = 'Nonaktifkan Layanan?';
                    var text = 'Klik "Lanjutkan" untuk menonaktifkan layanan Cetak Foto!';
                }
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='pengaturan.php?update_status=true&cetak_foto='+val;
                }
            });
        });

        $('.pembayaran_langsung').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#langsung_nonaktif').prop('checked', true);
                var title = 'Aktifkan Metode Pembayaran?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan metode Pembayaran Langsung!';
            } else {
                $('#langsung_aktif').prop('checked', true);
                if ($("input[name='pembayaran_virtual']:checked").val() == '0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak dapat diproses',
                        text: 'Salah satu metode pembayaran harus aktif',
                    });
                    return;
                } else {
                    var title = 'Nonaktifkan Metode Pembayaran?';
                    var text = 'Klik "Lanjutkan" untuk menonaktifkan metode Pembayaran Langsung!';
                }
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='pengaturan.php?update_status=true&pembayaran_langsung='+val;
                }
            });
        });

        $('.pembayaran_virtual').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#virtual_nonaktif').prop('checked', true);
                var title = 'Aktifkan Metode Pembayaran?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan metode Pembayaran Virtual!';
            } else {
                $('#virtual_aktif').prop('checked', true);
                if ($("input[name='pembayaran_langsung']:checked").val() == '0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak dapat diproses',
                        text: 'Salah satu metode pembayaran harus aktif',
                    });
                    return;
                } else {
                    var title = 'Nonaktifkan Metode Pembayaran?';
                    var text = 'Klik "Lanjutkan" untuk menonaktifkan metode Pembayaran Virtual!';
                }
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='pengaturan.php?update_status=true&pembayaran_virtual='+val;
                }
            });
        });

        $('.status_lyn').change(function(event) {
            var val = $(this).val();
            if (val == 'active') {
                $('#status_nonaktif').prop('checked', true);
                var title = 'Aktifkan Status Layanan?';
                var text = 'Anda dapat menerima pesanan dan percetakan anda akan di tampilkan di pencarian user';
            } else {
                $('#status_aktif').prop('checked', true);
                var title = 'Nonaktifkan Status Layanan?';
                var text = 'Jika anda menonaktifkan status layanan, anda tidak dapat menerima pesanan lagi!';
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='pengaturan.php?status_layanan=true&value='+val;
                }
            });
        });


        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui',
                preConfirm: () => {
                    window.location.href='pengaturan.php';
                }
            });
        <?php } 
        if (isset($antrian)) {?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Diproses',
                text: 'Saat ini anda tidak dapat menonaktifkan status layanan. Selesaikan semua pesanan terlebih dahulu!',
                preConfirm: () => {
                    window.location.href='pengaturan.php';
                }
            });
        <?php } ?>
    });
</script>