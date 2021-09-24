<?php

require('template/header.php');

$id = $_SESSION['id_mitra'];

$row = lihat_profil($id);

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
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Lengkapi Datamu!!!</h5>
                <table class="mb-0 table table-bordered">
                    <tbody>
                        <tr>
                            <td>Foto Profil</td>
                            <td><img src="img/daftar<?= $row["poto"];?>" alt="" height="250"> </td>
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
    </div>

<?php
require('template/footer.php');
?>