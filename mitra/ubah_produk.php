<?php

require '../function.php';

$id=$_GET["id"];

$ubah = query("SELECT * FROM produk WHERE id = $id") [0];

if (isset($_POST["submit"])) {

    $_POST["id"] = $id;

    if (ubah_produk($_POST)) {
        echo "<script> 
             alert ('Data diubah');
             document.location.href = 'pengaturan.php';
         </script>";
    }
    else {
        echo "<script> 
             alert ('Data Gagal diubah');
             document.location.href = 'pengaturan.php';
         </script>";
    }
}

require('template/header.php');
?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-keyboard icon-gradient bg-mixed-hopes">
                        </i>
                    </div>
                    <div>Ubah Data Produk</div>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <form class="" action="" method="POST">
                                <input type="hidden" name="id" id="id" value="<?= $ubah["id"]; ?>">
                                <div class="position-relative form-group">
                                    <label for="jenis" class="">Jenis Produk</label>
                                    <input required name="jenis" id="jenis" value="<?= $ubah["jenis"]; ?>" type="text" class="form-control">
                                </div>
                                <div class="position-relative form-group">
                                    <label for="harga" class="">Harga</label>
                                    <input name="harga" id="harga" value="<?= $ubah["harga"]; ?>" type="number" class="form-control">
                                </div>
                                    <button type="submit" name="submit" class="mt-1 btn btn-primary">Ubah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<?php
require('template/footer.php');
?>