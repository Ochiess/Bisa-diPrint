<?php

require('template/header.php');

$agen_id = $_SESSION['id_mitra'];
$success = false;

if (isset($_POST['add_layanan'])) {
    $nama_layanan = $_POST['nama_layanan'];
    $jenis_file = $_POST['jenis_file'];
    $waktu_kerja = $_POST['waktu_kerja'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn, "INSERT INTO layanan VALUES(NULL, '$agen_id', '$nama_layanan', '$jenis_file', '$waktu_kerja', '$keterangan')");
    $success = true;
}

if (isset($_POST['edit_layanan'])) {
    $id = $_POST['id'];
    $nama_layanan = $_POST['nama_layanan'];
    $jenis_file = $_POST['jenis_file'];
    $waktu_kerja = $_POST['waktu_kerja'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama_layanan', jenis_file='$jenis_file', waktu_kerja=' $waktu_kerja', keterangan='$keterangan' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['hapus_data'])) {
    $id = $_GET['id'];
    $atribut = mysqli_query($conn, "SELECT * FROM atribut_layanan WHERE layanan_id='$id'");
    foreach ($atribut as $atr) {
        $atr_id = $atr['id'];
        mysqli_query($conn, "DELETE FROM item_layanan WHERE atribut_id='$atr_id'");
    }
    mysqli_query($conn, "DELETE FROM atribut_layanan WHERE layanan_id='$id'");
    mysqli_query($conn, "DELETE FROM layanan WHERE id='$id'");
    $success = true;
}

$layanan = mysqli_query($conn, "SELECT * FROM layanan WHERE agen_id='$agen_id'");
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
            <h5 class="card-title">Pengaturan Layanan</h5>
            <hr>
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target=".modal-add-layanan"><i class="fa fa-plus-circle"></i> Tambah Layanan</button>
            <div class="row">
                <div class="col-md-12">
                    <table class="mb-0 table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Jenis File</th>
                                <th>Estimasi Kerja</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($layanan as $ly) { 
                                $dis=false;
                                if ($ly['nama_layanan'] == 'Cetak Dokumen' || $ly['nama_layanan'] == 'Cetak Foto') $dis=true; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $ly['nama_layanan'] ?></td>
                                    <td><?= ucwords($ly['jenis_file']) ?></td>
                                    <td><?= ($ly['waktu_kerja']==0) ? '-' : $ly['waktu_kerja'].' Menit' ?></td>
                                    <td><?= $ly['keterangan'] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-edt-layanan<?= $ly['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Edit Layanan"><i class="fa fa-edit"></i></button>
                                        <?php if ($dis) { ?>
                                            <button class="btn btn-sm btn-danger" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Layanan" disabled=""><i class="fa fa-trash"></i></button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-layanan<?= $ly['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Layanan"><i class="fa fa-trash"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $no=$no+1;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <h5 class="card-title mt-4">Metode Pembayaran</h5>
            <hr>
            <div>

            </div>

            <h5 class="card-title mt-4">Profile Mitra</h5>
            <hr>
            <div>

            </div>

            <h5 class="card-title mt-4">Status Layanan</h5>
            <hr>
            <div>

            </div>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<!-- MODAL TAMBAH -->
<div class="modal modal-add-layanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Layanan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group row">
                        <label class="col-md-4">Nama Layanan</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_layanan" required="required" class="form-control" placeholder="Nama Layanan..." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Jenis File Upload</label>
                        <div class="col-md-8">
                            <?php $berkas = [['dokumen', 'Dokumen (docx, pdf, dll)'], ['foto', 'Foto (png, jpg, dll)']]; ?>
                            <select class="form-control" name="jenis_file" required="">
                                <option value="">--Pilih Jenis Berkas--</option>
                                <?php foreach ($berkas as $bks) { ?>
                                    <option value="<?= $bks[0] ?>"><?= $bks[1] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Estimasi Waktu Kerja</label>
                        <div class="col-md-8">
                            <input type="number" name="waktu_kerja" required="required" class="form-control" placeholder="Estimasi Waktu Kerja (Menit)" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Keterangan</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="keterangan" placeholder="Keterangan..." required=""></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" name="add_layanan" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($layanan as $ly) {
    $dis=false;
    if ($ly['nama_layanan'] == 'Cetak Dokumen' || $ly['nama_layanan'] == 'Cetak Foto') $dis=true;
    ?>
    <!-- MODAL EDIT -->
    <div class="modal" id="modal-edt-layanan<?= $ly['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Data Layanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST">
                        <div class="form-group row">
                            <label class="col-md-4">Nama Layanan</label>
                            <div class="col-md-8">
                                <input type="text" name="nama_layanan" required="required" class="form-control" placeholder="Nama Layanan..." autocomplete="off" value="<?= $ly['nama_layanan'] ?>" <?= $dis ? 'readonly' : '' ?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Jenis File Upload</label>
                            <div class="col-md-8">
                                <?php $berkas = [['dokumen', 'Dokumen (docx, pdf, dll)'], ['foto', 'Foto (png, jpg, dll)']]; ?>
                                <input type="hidden" name="jenis_file" value="<?= $ly['jenis_file'] ?>">
                                <select class="form-control" name="jenis_file" required="" <?= $dis ? 'disabled' : '' ?>>
                                    <option value="">--Pilih Jenis Berkas--</option>
                                    <?php foreach ($berkas as $bks) { ?>
                                        <option value="<?= $bks[0] ?>" <?php if ($bks[0] == $ly['jenis_file']) echo "selected" ?>><?= $bks[1] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Estimasi Waktu Kerja</label>
                            <div class="col-md-8">
                                <input type="number" name="waktu_kerja" required="required" class="form-control" placeholder="Estimasi Waktu Kerja (Menit)" autocomplete="off" value="<?= $ly['waktu_kerja'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Keterangan</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="keterangan" placeholder="Keterangan..." required=""><?= $ly['keterangan'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="hidden" name="id" value="<?= $ly['id'] ?>">
                                <button type="submit" name="edit_layanan" class="btn btn-success">Simpan</button>
                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-layanan<?= $ly['id'] ?>">
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
                        <p>
                            Yakin ingin menghapus layanan ini? Semua Ataribut Layanan juga akan dihapus!
                        </p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="?hapus_data=true&id=<?= $ly['id'] ?>" role="button" class="btn btn-danger">Hapus</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


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