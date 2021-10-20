<?php
require('template/header.php');

$id = $_SESSION['id_mitra'];

$edit = query("SELECT * FROM agen WHERE id='$id'") [0];

if (isset($_POST["submit"])) {

    $_POST["id"] = $id;

    if(ubah_profil($_POST)) {
        echo "<script>
        alert ('Profil diPerbaharui!!!');
        document.location.href = 'profil.php';
        </script>";
    } else {
        echo "<script>
        alert ('Gagal Memperbaharui Profil!!!');
        document.location.href = 'profil.php';
        </script>";
    }
}

?>
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
                        <input name="poto" id="poto" type="file" value="<?= $edit["poto"]; ?>" class="form-control-file">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleEmail" class="col-sm-2 col-form-label">Nama Percetakan</label>
                    <div class="col-sm-10">
                        <input name="nama_percetakan" id="nama_percetakan" type="text" value="<?= $edit["nama_percetakan"]; ?>" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleEmail" class="col-sm-2 col-form-label">Nama Pemilik</label>
                    <div class="col-sm-10">
                        <input name="nama_pemilik" id="nama_pemilik" type="text" value="<?= $edit["nama_pemilik"]; ?>" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleEmail" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input name="telpon" id="telpon" type="number" value="<?= $edit["telpon"]; ?>" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="email" id="email" type="email" value="<?= $edit["email"]; ?>" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleEmail" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input name="alamat" id="alamat" type="text" value="<?= $edit["alamat"]; ?>" class="form-control">
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