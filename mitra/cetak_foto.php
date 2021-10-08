<?php

require('template/header.php');

$agen_id = $_SESSION['id_mitra'];
$success = false;

if (isset($_POST['add_ukuran'])) {
    $ukuran = $_POST['ukuran'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "INSERT INTO ukuran_foto VALUES(NULL, '$agen_id', '$ukuran', '$harga')");
    $success = true;
}

if (isset($_POST['edit_ukuran'])) {
    $id = $_POST['id'];
    $ukuran = $_POST['ukuran'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "UPDATE ukuran_foto SET ukuran='$ukuran', harga='$harga' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['hapus_ukuran'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM ukuran_foto WHERE id='$id'");
    $success = true;
}

if (isset($_GET['status_latar'])) {
    $value = $_GET['value'];
    mysqli_query($conn, "UPDATE setting_agen SET latar='$value' WHERE agen_id='$agen_id'");
    $success = true;
}

$ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE agen_id='$agen_id'");
$config = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$agen_id'");
$cfg = mysqli_fetch_assoc($config);
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note2 icon-gradient bg-deep-blue"></i>
                </div>
                <div>Atur Layanan (Cetak Foto)</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Layanan</h5>
            <hr>
            <div class="main-card mb-3 card border">
                <div class="card-header">Atur Ukuran Foto</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><b>Tambah Ukuran Foto</b></label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ukuran Foto</label>
                                    <input type="text" name="ukuran" required="required" class="form-control" placeholder="Ukuran Foto.." autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" placeholder="Input harga jika ada" autocomplete="off" value="">
                                </div>
                            </div>
                            <div class="col-md-2 pt-4">
                                <button class="btn btn-primary mt-2" type="submit" name="add_ukuran"><i class="fa fa-plus-circle"></i> Tambah</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><b>List Ukuran Foto</b></label>
                        </div>
                        <div class="col-md-8">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="1">No</th>
                                        <th>Ukuran Foto</th>
                                        <th>Harga (Rp)</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach($ukuran_foto as $ukf) { ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $ukf['ukuran'] ?></td>
                                            <td><?= $ukf['harga'] ? 'Rp.'.number_format($ukf['harga']).'/lembar' : '-' ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edt-ukuran<?= $ukf['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Edit Ukuran Foto"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-ukuran<?= $ukf['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Ukuran Foto"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php 
                                        $no=$no+1;
                                    }
                                    if ($no==1) { ?>
                                        <tr>
                                            <td colspan="4" class="text-center"><i>Belum ada data</i></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card border">
                <div class="card-header">Layanan Ganti Latar Foto</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label><b>Status Layanan</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="latar_aktif" name="status_latar" class="custom-control-input status_latar" value="1" <?= ($cfg['latar']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="latar_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="latar_nonaktif" name="status_latar" class="custom-control-input status_latar" value="0" <?= ($cfg['latar']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="latar_nonaktif">Tidak Aktif</label>
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

foreach ($ukuran_foto as $dta) { ?>
    <!-- MODAL EDIT UKURAN FOTO -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edt-ukuran<?= $dta['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kertas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST">
                        <div class="form-group row">
                            <label class="col-md-4">Ukuran Foto</label>
                            <div class="col-md-8">
                                <input type="text" name="ukuran" required="required" class="form-control" placeholder="Ukuran Foto.." value="<?= $dta['ukuran'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Harga (Rp)</label>
                            <div class="col-md-8">
                                <input type="number" name="harga" class="form-control" placeholder="Harga (Optional)" autocomplete="off" value="<?= $dta['harga'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="hidden" name="id" value="<?= $dta['id'] ?>">
                                <button type="submit" name="edit_ukuran" class="btn btn-success">Simpan</button>
                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS UKURAN FOTO -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-ukuran<?= $dta['id'] ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="?hapus_ukuran=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger" name="edit_data">Hapus</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-layanan').addClass('mm-active');
        $('#sub-layanan').addClass('mm-show');
        $('#nv-cetak-foto').addClass('mm-active');

        $('.status_latar').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#latar_nonaktif').prop('checked', true);
                var title = 'Aktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan layanan ganti latar foto!';
            } else {
                $('#latar_aktif').prop('checked', true);
                var title = 'Nonaktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk menonaktifkan layanan ganti latar foto!';
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='cetak_foto.php?status_latar=true&value='+val;
                }
            });
        });

        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui',
                preConfirm: () => {
                    window.location.href='cetak_foto.php';
                }
            });
        <?php } ?>
    });
</script>