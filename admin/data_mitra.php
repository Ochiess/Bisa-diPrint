<?php
require('template/header.php');

$success = false;
if (isset($_POST['update_password'])) {
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE agen SET password = '$password' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['banned'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE agen SET status = 'banned' WHERE id='$id'");
    $success = true;
}

if (isset($_GET['active'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE agen SET status = 'active' WHERE id='$id'");
    $success = true;
}

$mitra = mysqli_query($conn, "SELECT * FROM agen WHERE status='active' OR status='nonactive' OR status='banned'");
?>
<!--main content-->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-medal icon-gradient bg-deep-blue"></i>
                </div>
                <div>Daftar Mitra</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table class="mb-0 table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Photo</th>
                                <th>Nama Percetakan</th>
                                <th>Nama Pemilik</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($mitra as $dta) { 
                                if ($dta['status'] == 'active') $color ='success';
                                else if ($dta['status'] == 'nonactive') $color = 'warning';
                                else if ($dta['status'] == 'banned') $color = 'danger';
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
                                    <td><span class="badge badge-pill badge-<?= $color ?>"><?= $dta['status'] ?></span></td>
                                    <td>
                                        <button class="mb-2 mr-2 btn btn-primary" data-toggle="modal" data-target=".modal-restpass<?= $dta['id'] ?>"><i class="fa fa-key"></i> Reset Password</button>
                                        <?php if ($dta['status'] != 'banned') { ?>
                                            <button class="mb-2 mr-2 btn btn-danger" data-toggle="modal" data-target=".modal-banned<?= $dta['id'] ?>"><i class="fa fa-times-circle"></i> Banned</button>
                                        <?php } else { ?>
                                            <button class="mb-2 mr-2 btn btn-success" data-toggle="modal" data-target=".modal-aktifkan<?= $dta['id'] ?>"><i class="fa fa-check-circle"></i> Aktifkan</button>
                                        <?php } ?>
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
    <!-- MODAL GANTI PASSWORD -->
    <div class="modal fade modal-restpass<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password Mitra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <lable class="form-lable">Nama Percetakan</lable>
                            <input class="form-control" type="text" required="" value="<?= $dta['nama_percetakan'] ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <lable class="form-lable">Password Baru</lable>
                            <input class="form-control" placeholder="Password Baru..." name="password" type="text" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <input type="hidden" name="id" value="<?= $dta['id'] ?>">
                        <button type="submit" class="btn btn-success" name="update_password">Update Password</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL BANNED -->
    <div class="modal fade modal-banned<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Banned Mitra Ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Silahkan klik "Banned" untuk melanjutkan aksi!
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <a href="data_mitra.php?banned=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger">Banned</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BANNED -->
    <div class="modal fade modal-aktifkan<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aktifka Kembali Mitra Ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Silahkan klik "Aktifkan" untuk melanjutkan aksi!
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <a href="data_mitra.php?active=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-success">Aktifkan</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-mitra').addClass('mm-active');

        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui'
            }).then(function() {
                window.location.href='data_mitra.php';
            });
        <?php } ?>
    });
</script>