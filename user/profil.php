<?php

require('template/header.php');

$id = $_SESSION['key'];

$row = tampil_profil($id);

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-paint icon-gradient bg-deep-blue"></i>
                    </div>
                    <div>Profil Saya</div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Lengkapi Datamu!!!</h5>
                    <table class="mb-0 table table-bordered">
                        <tbody>
                            <tr>
                                <td>Foto Profil</td>
                                <td>
                                    <?php if ($row["photo"]) { ?>
                                        <img width="42" class="rounded-circle" src="../user/img/<?= $row['photo'] ?>" alt="" height="41">
                                    <?php } else { ?>
                                        <img width="42" class="rounded-circle" src="../user/img/default.png" alt="" height="41">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td><?= $row["nama_lengkap"];?></td>
                            </tr>
                            <tr>
                                <td>Nama Akun</td>
                                <td><?= $row["nama_akun"];?></td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td><?= $row["hp"];?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $row["email"];?></td>
                            </tr>
                            
                        </tbody>
                        <a href="edit_profil.php?id=<?=$row["id"]; ?>" type="Submit" name="submit" class="mb-2 mr-2 btn btn-primary">Ubah</a>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    require('template/footer.php');
?>