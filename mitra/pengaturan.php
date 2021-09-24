<?php

require('template/header.php');

$id = $_SESSION["id_mitra"];

if (isset($_POST["tambah"])) {

    $_POST["id"] = $id;

    if (tambah_produk($_POST)) {
        echo "<script> 
             alert ('Data ditambah');
         </script>";
    }
}

$result = baca_produk($id);

?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-cog icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Setting Profil Produk</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Tambah</button>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Jenis Produk</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row) {
                                    echo '
                                        <tr>
                                            <td>' . $row["jenis"] . '</td>
                                            <td>' . $row["harga"] . '</td>
                                            <td>
                                                <a href="ubah_produk.php?id='. $row["id"] .'" class="mb-2 mr-2 btn btn-primary">Edit</a>
                                                <a href="hapus_produk.php?id='. $row["id"] .'" class="mb-2 mr-2 btn btn-danger" onclick="return confirm("Yakin Menghapus ?");">Hapus</a>
                                            </td>
                                        </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Produk</h5>
            </div>
            <form class="" action="" method="POST">
                <div class="modal-body">
                    <div class="position-relative form-group">
                        <div class="position-relative form-group">
                            <label for="jenis" class="">Jenis Produk</label>
                            <input required name="jenis" id="jenis" type="text" placeholder="Contoh: Kertas Berwarna" class="form-control">
                        </div>  
                    </div>
                    <div class="position-relative form-group">
                        <label for="harga" class="">Harga</label>
                        <input required name="harga" id="harga" type="number" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>