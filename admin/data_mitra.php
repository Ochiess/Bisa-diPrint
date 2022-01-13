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

$res_transfer_saldo = false;
if (isset($_POST['transfer_saldo'])) {
    $agen_id = $_POST['agen_id'];
    $this_saldo = $_POST['this_saldo'];
    $saldo_akun = $_POST['saldo_akun'];
    $jumlah = $_POST['jumlah'];
    $potongan = $_POST['potongan'];
    $set_potongan = $jumlah * $potongan / 100;
    if ($jumlah < 10000 || $jumlah > $this_saldo) {
        echo "<script>
        alert('Maaf, Saldo yang dimasukkan tidak mencukupi atau nominal salah.');
        window.location.href=window.location.href;
        </script>";
        exit();
    }

    $jumlah_saldo = $this_saldo - $jumlah;
    $saldo_akun = $saldo_akun + ($jumlah - $set_potongan);

    mysqli_query($conn, "UPDATE virtual_payment SET jumlah_saldo='$jumlah_saldo', saldo_akun='$saldo_akun' WHERE agen_id='$agen_id'");
    $res_transfer_saldo = true;
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
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($mitra as $dta) {
                                if ($dta['status'] == 'active') $color = 'success';
                                else if ($dta['status'] == 'nonactive') $color = 'warning';
                                else if ($dta['status'] == 'banned') $color = 'danger';

                                $agen_id = $dta['id'];
                                $get_payment = mysqli_query($conn, "SELECT * FROM virtual_payment WHERE agen_id='$agen_id'");
                                $pay = mysqli_fetch_assoc($get_payment);
                            ?>
                                <tr>
                                    <th><?= $no ?></th>
                                    <td>
                                        <?php if ($dta["poto"]) { ?>
                                            <img width=" 60" class="rounded-circle" src="../mitra/img/daftar<?= $dta['poto'] ?>" alt="" height="60">
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
                                    <td class="text-center">
                                        <?php if ($dta['status'] != 'banned' && isset($pay['agen_id'])) { ?>
                                            <span data-toggle="modal" data-target=".modal-transfer-saldo<?= $dta['id'] ?>">
                                                <button class="btn btn-sm btn-primary btn-transfer" data-id="<?= $dta['id'] ?>" data-toggle="tooltip" data-original-title="Transfer Saldo Pemasukan"><i class="fas fa-credit-card"></i></button>
                                            </span>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-primary disabled pay-not-found" data-toggle="tooltip" data-original-title="Transfer Saldo Pemasukan"><i class="fas fa-credit-card"></i></button>
                                        <?php } ?>
                                        <span data-toggle="modal" data-target=".modal-restpass<?= $dta['id'] ?>">
                                            <button class="btn btn-sm btn-secondary" data-toggle="tooltip" data-original-title="Reset Password"><i class="fa fa-key"></i></button>
                                        </span>
                                        <?php if ($dta['status'] != 'banned') { ?>
                                            <span data-toggle="modal" data-target=".modal-banned<?= $dta['id'] ?>">
                                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="Banned"><i class="fa fa-times-circle"></i></button>
                                            </span>
                                        <?php } else { ?>
                                            <span data-toggle="modal" data-target=".modal-aktifkan<?= $dta['id'] ?>">
                                                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-original-title="Aktifkan"><i class="fa fa-check-circle"></i></button>
                                            </span>
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

foreach ($mitra as $dta) {
    $agen_id = $dta['id'];
    $get_payment = mysqli_query($conn, "SELECT * FROM virtual_payment WHERE agen_id='$agen_id'");
    $pay = mysqli_fetch_assoc($get_payment); ?>
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

    <!-- MODAL AKTIF -->
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

    <?php if (isset($pay['agen_id'])) {
        $vals = substr($pay['jumlah_saldo'], 0, 1);
        for ($i = 0; $i < strlen($pay['jumlah_saldo']) - 1; $i++) {
            $vals .= '0';
        }
        $set_value = $vals ?>
        <!-- MODAL TRANSFER SALDO -->
        <div class="modal fade modal-transfer-saldo<?= $dta['id'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Transfer Saldo Pemasukan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <h4 class="text-center"><?= strtoupper($dta['nama_percetakan']) ?></h4>
                            <h4 class="text-center text-success">Saldo: Rp.<?= number_format($pay['jumlah_saldo']) ?></h4>
                            <div class="text-center">
                                <span class="text-info">Note: Minimal transfer saldo Rp10.000</span>
                            </div>
                            <hr>
                            <div class="px-3">
                                <div class="form-group">
                                    <label>Jumlah Transfer (Rp)</label>
                                    <input type="hidden" name="agen_id" value="<?= $dta['id'] ?>">
                                    <input type="hidden" name="saldo_akun" value="<?= $pay['saldo_akun'] ?>">
                                    <input type="hidden" name="this_saldo" class="this_saldo" value="<?= $pay['jumlah_saldo'] ?>">
                                    <input type="number" name="jumlah" class="form-control jumlah_transfer" placeholder="Jumlah Transfer.." required="" autocomplete="off" value="<?= $set_value ?>">
                                    <small class="text-danger info-danger" hidden></small>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Potongan Pendapatan</label>
                                            <?php
                                            $potongan = ["5", "10", "15", "20"];
                                            ?>
                                            <select class="form-control potongan" name="potongan" required="">
                                                <?php foreach ($potongan as $cut) { ?>
                                                    <option value="<?= $cut ?>"><?= $cut ?>%</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td><b>Jumlah Pendapatan</b></td>
                                                <td><b>Jumlah Transfer</b></td>
                                            </tr>
                                            <tr>
                                                <td class="jum_pendapatan">Rp.0</td>
                                                <td class="jum_transfer">Rp.0</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke">
                            <button type="submit" class="btn btn-success" name="transfer_saldo">Lanjutkan Transfer</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Jadi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php }
} ?>

<script>
    $(document).ready(function() {
        $('#nv-mitra').addClass('mm-active');

        $('.btn-transfer').click(function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var find = $(document).find('.modal-transfer-saldo' + id);
            var saldo_input = find.find('.jumlah_transfer').val();
            var potongan = find.find('.potongan').val();
            var get_potongan = parseInt(saldo_input) * potongan / 100;
            find.find('.jum_pendapatan').text('Rp.' + get_potongan);
            find.find('.jum_transfer').text('Rp.' + (parseInt(saldo_input) - get_potongan));
            if (parseInt(saldo_input) < 10000) {
                find.find('.jumlah_transfer').addClass('border-danger text-danger');
                find.find('.info-danger').removeAttr('hidden').text('Jumlah minimal transfer tidak mencukupi');
                find.find('.jum_pendapatan').text('Rp.0');
                find.find('.jum_transfer').text('Rp.0');
            }
        });

        $(document).on('keyup', '.jumlah_transfer', function() {
            var find = $(this).parents('.modal');
            var saldo_input = $(this).val();
            var this_saldo = find.find('.this_saldo').val();
            var potongan = find.find('.potongan').val();
            var get_potongan = parseInt(saldo_input) * potongan / 100;

            if ((parseInt(saldo_input) >= 10000) && (parseInt(this_saldo) >= parseInt(saldo_input))) {
                $(this).removeClass('border-danger text-danger');
                find.find('.info-danger').attr('hidden', '');
                find.find('.jum_pendapatan').text('Rp.' + get_potongan);
                var jum_transfer = parseInt(saldo_input) - get_potongan;
                find.find('.jum_transfer').text('Rp.' + (jum_transfer));
            } else if (parseInt(this_saldo) < parseInt(saldo_input)) {
                $(this).addClass('border-danger text-danger');
                find.find('.info-danger').removeAttr('hidden').text('Jumlah saldo tidak mencukupi');
                find.find('.jum_pendapatan').text('Rp.0');
                find.find('.jum_transfer').text('Rp.0');
            } else if (parseInt(saldo_input) < 10000) {
                $(this).addClass('border-danger text-danger');
                find.find('.info-danger').removeAttr('hidden').text('Jumlah minimal transfer tidak mencukupi');
                find.find('.jum_pendapatan').text('Rp.0');
                find.find('.jum_transfer').text('Rp.0');
            }
        });
        $(document).on('change', '.potongan', function() {
            var find = $(this).parents('.modal');
            var potongan = $(this).val();
            var this_saldo = find.find('.this_saldo').val();
            var saldo_input = find.find('.jumlah_transfer').val();
            var get_potongan = parseInt(saldo_input) * potongan / 100;

            if ((parseInt(saldo_input) >= 10000) && (parseInt(this_saldo) >= parseInt(saldo_input))) {
                find.find('.jum_pendapatan').text('Rp.' + get_potongan);
                var jum_transfer = parseInt(saldo_input) - get_potongan;
                find.find('.jum_transfer').text('Rp.' + (jum_transfer));
            } else if (parseInt(this_saldo) < parseInt(saldo_input)) {
                find.find('.jum_pendapatan').text('Rp.0');
                find.find('.jum_transfer').text('Rp.0');
            } else if (parseInt(saldo_input) < 10000) {
                find.find('.jum_pendapatan').text('Rp.0');
                find.find('.jum_transfer').text('Rp.0');
            }
        });

        $('.pay-not-found').click(function(event) {
            iziToast.warning({
                title: 'Tidak Tersedia',
                message: 'Pembayaran Virtual belum aktif atau akun sedang dikunci!',
                position: 'topRight'
            });
        });

        <?php if ($success == true) { ?> Swal.fire({
                icon: 'success',
                title: 'Berhasil Diproses',
                text: 'Data telah telah diperbarui'
            }).then(function() {
                window.location.href = 'data_mitra.php';
            });
        <?php } ?>

        <?php if ($res_transfer_saldo == true) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Transfer Berhasil',
                text: 'Transfer saldo telah berhasil dilakukan. Saldo yang ditransfer akan segera masuk ke akun agen yang dituju'
            }).then(function() {
                location.href = window.location.href;
            });
        <?php } ?>
    });
</script>