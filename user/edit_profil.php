<?php

require('template/header.php');

$id = $_SESSION['key'];

$update = query("SELECT * FROM user WHERE id='$id'") [0];

if (isset($_POST["submit"])) {

    $_POST["id"] = $id;

    if(update_profil($_POST)) {
        echo"<script>
            alert('Profil di Update');
            document.location.href = 'profil.php';
        </script>";
    } else {
        echo "<script>
            alert('Profil Gagal di Update!')
            document.location.href = 'profil.php';
        </script>";
    }
}

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
                <h5 class="card-title">Perbarui Profil</h5>
                <form class="" action="" method="POST" enctype="multipart/form-data">
                    <div class="position-relative row form-group">
                        <label for="exampleFile" class="col-sm-2 col-form-label">Upload Photo</label>
                        <div class="col-sm-10">
                            <input name="photo" id="photo" type="file" value="<?= $update["photo"]; ?>" class="form-control-file">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input name="nama_lengkap" id="nama_lengkap" type="text" value="<?= $update["nama_lengkap"]; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-2 col-form-label">Nama Akun</label>
                        <div class="col-sm-10">
                            <input name="nama_akun" id="nama_akun" type="text" value="<?= $update["nama_akun"]; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input name="hp" id="hp" type="number" value="<?= $update["hp"]; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input name="email" id="email" type="email" value="<?= $update["email"]; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <a href="profil.php" class="btn btn-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit" name="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php
    require('template/footer.php');
    ?>

    <!-- <script>
        $('#btn').on('click', function(e) {
            Swal.fire({
                type: 'danger',
                title: 'Ooops..',
                text: 'Photonya tidak diganti!',
            })
        })
    </script> -->
    <!-- <script>
        $('#btt').on('click', function(){
            Swal.fire(
                'Good Job!',
                'You Clicked the button',
                'succe'
            )
        })
    </script> -->


