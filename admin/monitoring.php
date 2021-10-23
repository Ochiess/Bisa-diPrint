<?php
require('template/header.php');

$mitra = mysqli_query($conn, "SELECT * FROM agen WHERE status='new'");

if (isset($_GET['tolak'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE agen SET status = 'refuse' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['terima'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE agen SET status = 'active' WHERE id='$id'");
    $success = true;
}
?>
<!--main content-->

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-check icon-gradient bg-deep-blue"></i>
                </div>
                <div>Validasi Pengguna</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="mb-0 table table-bordered" id="dataTable">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Photo</th>
                                <th>Nama Percetakan</th>
                                <th>Nama Pemilik</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($mitra as $dta) { 
                                ?>
                                <tr>
                                    <th><?= $no ?></th>
                                    <td>
                                        <?php if ($dta["poto"]) { ?>
                                            <img width="60" class="rounded-circle" src="../mitra/img/daftar<?= $dta['poto'] ?>" alt="" height="60">
                                        <?php } else { ?>
                                            <img width="60" class="rounded-circle" src="../user/img/default.png" alt="" height="60">
                                        <?php } ?>
                                    </td>
                                    <td><?= $dta['nama_percetakan'] ?></td>
                                    <td><?= $dta['nama_pemilik'] ?></td>
                                    <td><?= $dta['telpon'] ?></td>
                                    <td><?= $dta['email'] ?></td>
                                    <td><?= $dta['alamat'] ?></td>
                                    <td><?= $dta['keterangan'] ?></td>
                                    <td>
                                        <button class="mb-2 mr-2 btn btn-success btn-block" data-toggle="modal" data-target=".modal-terima<?= $dta['id'] ?>"><i class="fa fa-check-circle"></i> Terima</button>
                                        <button class="mb-2 mr-2 btn btn-danger btn-block" data-toggle="modal" data-target=".modal-tolak<?= $dta['id'] ?>"><i class="fa fa-times-circle"></i> Tolak</button>
                                    </td>
                                </tr>
                                <?php $no++;
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

foreach ($mitra as $dta) { ?>
    <!-- MODAL TOLAK -->
    <div class="modal fade modal-tolak<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pendaftar Ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Silahkan klik "Tolak" untuk melanjutkan aksi!
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <a href="monitoring.php?tolak=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger">Tolak</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TERIMA -->
    <div class="modal fade modal-terima<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terima Pendaftar Ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Silahkan klik "Terima" untuk melanjutkan aksi!
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <a href="monitoring.php?terima=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-success">Terima</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#nv-validasi').addClass('mm-active');

        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui'
            }).then(function() {
                window.location.href='monitoring.php';
            });
        <?php } ?>
    });
</script>