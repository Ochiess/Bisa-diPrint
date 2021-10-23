<?php
require('template/header.php');

$success = false;
if (isset($_POST['update_password'])) {
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE user SET password = '$password' WHERE id='$id'");
    $success = true;
}

$user = mysqli_query($conn, "SELECT * FROM user ORDER BY id DESC");
?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-users icon-gradient bg-deep-blue"></i>
                </div>
                <div>Daftar Pengguna</div>
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
                                <th>Nama Lengkap</th>
                                <th>Nama Akun</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($user as $dta) { 
                                ?>
                                <tr>
                                    <th><?= $no ?></th>
                                    <td>
                                        <?php if ($dta["photo"]) { ?>
                                            <img width="60" class="rounded-circle" src="../user/img/<?= $dta['photo'] ?>" alt="" height="60">
                                        <?php } else { ?>
                                            <img width="60" class="rounded-circle" src="../user/img/default.png" alt="" height="60">
                                        <?php } ?>
                                    </td>
                                    <td><?= $dta['nama_lengkap'] ?></td>
                                    <td><?= $dta['nama_akun'] ?></td>
                                    <td><?= $dta['hp'] ?></td>
                                    <td><?= $dta['email'] ?></td>
                                    <td>
                                        <button class="mb-2 mr-2 btn btn-primary" data-toggle="modal" data-target=".modal-restpass<?= $dta['id'] ?>"><i class="fa fa-key"></i> Reset Password</button>
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

foreach ($user as $dta) { ?>
    <!-- MODAL GANTI PASSWORD -->
    <div class="modal fade modal-restpass<?= $dta['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <lable class="form-lable">Nama Pengguna</lable>
                            <input class="form-control" type="text" required="" value="<?= $dta['nama_lengkap'] ?>" readonly="">
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
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nv-user').addClass('mm-active');

        <?php if ($success == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui'
            }).then(function() {
                window.location.href='data_user.php';
            });
        <?php } ?>
    });
</script>