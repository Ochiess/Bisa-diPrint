<?php

require('template/header.php');

$agen_id = $_SESSION['id_mitra'];
$success = false;

if (isset($_POST['edit_warnatulisan'])) {
    if (isset($_POST['hitam_putih'])) {
        $hitam_putih = $_POST['hitam_putih'];
        mysqli_query($conn, "UPDATE warna_tulisan SET hitam_putih='$hitam_putih' WHERE agen_id='$agen_id'");
    }
    if (isset($_POST['berwarna'])) {
        $berwarna = $_POST['berwarna'];
        mysqli_query($conn, "UPDATE warna_tulisan SET berwarna='$berwarna' WHERE agen_id='$agen_id'");
    }
    $success = true;
}

if (isset($_POST['add_kertas'])) {
    $jenis_kertas = $_POST['jenis_kertas'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "INSERT INTO jenis_kertas VALUES(NULL, '$agen_id', '$jenis_kertas', '$harga')");
    $success = true;
}

if (isset($_POST['edit_kertas'])) {
    $id = $_POST['id'];
    $jenis_kertas = $_POST['jenis_kertas'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "UPDATE jenis_kertas SET jenis_kertas='$jenis_kertas', harga='$harga' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['hapus_kertas'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM jenis_kertas WHERE id='$id'");
    $success = true;
}

if (isset($_POST['add_jilid'])) {
    $item = $_POST['item'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "INSERT INTO jilid VALUES(NULL, '$agen_id', '$item', '$harga')");
    $success = true;
}

if (isset($_POST['edit_jilid'])) {
    $id = $_POST['id'];
    $item = $_POST['item'];
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    mysqli_query($conn, "UPDATE jilid SET item='$item', harga='$harga' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['hapus_jilid'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM jilid WHERE id='$id'");
    $success = true;
}

if (isset($_GET['status_jilid'])) {
    $value = $_GET['value'];
    mysqli_query($conn, "UPDATE setting_agen SET jilid='$value' WHERE agen_id='$agen_id'");
    $success = true;
}

$jenis_kertas = mysqli_query($conn, "SELECT * FROM jenis_kertas WHERE agen_id='$agen_id'");
$jilid = mysqli_query($conn, "SELECT * FROM jilid WHERE agen_id='$agen_id'");
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
                <div>Atur Layanan (Cetak Dokumen)</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Layanan</h5>
            <hr>
            <div class="main-card mb-3 card border">
                <div class="card-header">Atur Warna Tulisan</div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                        $warna_tulisan = mysqli_query($conn, "SELECT * FROM warna_tulisan WHERE agen_id='$agen_id'");
                        $wrt = mysqli_fetch_assoc($warna_tulisan);
                        ?>
                        <div class="col-md-6">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Warna Tulisan</th>
                                        <th>Harga</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hitam-Putih</td>
                                        <td>Rp.<?= number_format($wrt['hitam_putih']) ?>/lembar</td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".modal-edt-hitamputih"><i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Berwarna</td>
                                        <td>Rp.<?= number_format($wrt['berwarna']) ?>/lembar</td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".modal-edt-berwarna"><i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card border">
                <div class="card-header">Atur Jenis Kertas</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><b>Tambah Jenis Kertas</b></label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis Kertas</label>
                                    <input type="text" name="jenis_kertas" required="required" class="form-control" placeholder="Jenis Kertas.." autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" placeholder="Input harga jika ada" autocomplete="off" value="">
                                </div>
                            </div>
                            <div class="col-md-2 pt-4">
                                <button class="btn btn-primary mt-2" type="submit" name="add_kertas"><i class="fa fa-plus-circle"></i> Tambah</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><b>List Jenis Kertas</b></label>
                        </div>
                        <div class="col-md-8">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="1">No</th>
                                        <th>Jenis Kertas</th>
                                        <th>Harga (Rp)</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach($jenis_kertas as $jnk) { ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $jnk['jenis_kertas'] ?></td>
                                            <td><?= $jnk['harga'] ? 'Rp.'.number_format($jnk['harga']).'/lembar' : '-' ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edt-kertas<?= $jnk['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Edit Kertas"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-kertas<?= $jnk['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Kertas"><i class="fa fa-trash"></i></button>
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
                <div class="card-header">Atur Layanan Jilid</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label><b>Status Layanan</b></label>
                        </div>
                        <div class="col-sm-1">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="jilid_aktif" name="status_jilid" class="custom-control-input status_jilid" value="1" <?= ($cfg['jilid']==1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="jilid_aktif">Aktif</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-radio custom-control">
                                <input type="radio" id="jilid_nonaktif" name="status_jilid" class="custom-control-input status_jilid" value="0" <?= ($cfg['jilid']==0) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="jilid_nonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                    <form method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><b>Tambah Jenis Jilid</b></label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis Jilid</label>
                                    <input type="text" name="item" required="required" class="form-control" placeholder="Jenis Jilid.." autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" placeholder="Harga.." autocomplete="off" value="">
                                </div>
                            </div>
                            <div class="col-md-2 pt-4">
                                <button class="btn btn-primary mt-2" type="submit" name="add_jilid"><i class="fa fa-plus-circle"></i> Tambah</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <label><b>List Jenis Jilid</b></label>
                        </div>
                        <div class="col-md-8">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="1">No</th>
                                        <th>Jenis Jilid</th>
                                        <th>Harga (Rp)</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach($jilid as $jld) { ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $jld['item'] ?></td>
                                            <td><?= $jld['harga'] ? 'Rp.'.number_format($jld['harga']) : '-' ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edt-jilid<?= $jld['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Edit Kertas"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-jilid<?= $jld['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Kertas"><i class="fa fa-trash"></i></button>
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
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<!-- MODAL EDIT WARNA TULISAN -->
<div class="modal modal-edt-hitamputih" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Harga Warna Tulisan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group row">
                        <label class="col-md-4">Warna Tulisan</label>
                        <div class="col-md-8">
                            <input type="text" required="required" class="form-control" readonly="" value="Hitam-Putih">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Harga (Rp)</label>
                        <div class="col-md-8">
                            <input type="number" name="hitam_putih" required="required" class="form-control" placeholder="Harga (Rp)" autocomplete="off" value="<?= $wrt['hitam_putih'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" name="edit_warnatulisan" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-edt-berwarna" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Harga Warna Tulisan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group row">
                        <label class="col-md-4">Warna Tulisan</label>
                        <div class="col-md-8">
                            <input type="text" required="required" class="form-control" readonly="" value="Berwarna">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Harga (Rp)</label>
                        <div class="col-md-8">
                            <input type="number" name="berwarna" required="required" class="form-control" placeholder="Harga (Rp)" autocomplete="off" value="<?= $wrt['berwarna'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" name="edit_warnatulisan" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($jenis_kertas as $dta) { ?>
    <!-- MODAL EDIT KERTAS -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edt-kertas<?= $dta['id'] ?>">
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
                            <label class="col-md-4">Jenis Kertas</label>
                            <div class="col-md-8">
                                <input type="text" name="jenis_kertas" required="required" class="form-control" placeholder="Jenis Kertas.." value="<?= $dta['jenis_kertas'] ?>" autocomplete="off">
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
                                <button type="submit" name="edit_kertas" class="btn btn-success">Simpan</button>
                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS KERTAS -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-kertas<?= $dta['id'] ?>">
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
                        <a href="?hapus_kertas=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger" name="edit_data">Hapus</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php foreach ($jilid as $dta) { ?>
    <!-- MODAL EDIT JILID -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edt-jilid<?= $dta['id'] ?>">
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
                            <label class="col-md-4">Jenis Jilid</label>
                            <div class="col-md-8">
                                <input type="text" name="item" required="required" class="form-control" placeholder="Jenis Jilid.." value="<?= $dta['item'] ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Harga (Rp)</label>
                            <div class="col-md-8">
                                <input type="number" name="harga" class="form-control" placeholder="Harga (Rp)" autocomplete="off" value="<?= $dta['harga'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="hidden" name="id" value="<?= $dta['id'] ?>">
                                <button type="submit" name="edit_jilid" class="btn btn-success">Simpan</button>
                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS JILID -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-jilid<?= $dta['id'] ?>">
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
                        <a href="?hapus_jilid=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger" name="edit_data">Hapus</a>
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
        $('#nv-cetak-dokumen').addClass('mm-active');

        $('.status_jilid').change(function(event) {
            var val = $(this).val();
            if (val == '1') {
                $('#jilid_nonaktif').prop('checked', true);
                var title = 'Aktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk mengaktifkan layanan jilid!';
            } else {
                $('#jilid_aktif').prop('checked', true);
                var title = 'Nonaktifkan Layanan?';
                var text = 'Klik "Lanjutkan" untuk menonaktifkan layanan jilid!';
            }

            Swal.fire({
                icon: 'info',
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                preConfirm: () => {
                    window.location.href='cetak_dokumen.php?status_jilid=true&value='+val;
                }
            });
        });

        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui',
                preConfirm: () => {
                    window.location.href='cetak_dokumen.php';
                }
            });
        <?php } ?>
    });
</script>