<?php

require('template/header.php');
require('../function.php');
$id_agen = $_GET['id'];
$result = panggil_produk($id_agen);

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa  fa-exclamation icon-gradient bg-deep-blue"></i>
                    </div>
                    <div>Infrormasi Percetakan</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="main-card card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Antrian Dalam Percetakan Ini</h5>
                        <table class="mb-0 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Penguna</th>
                                    <th>Waktu Kirim</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td class="text-center">
                                        <label class="badge badge-warning ">Status</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="main-card card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Harga Produk</h5>
                        <form action="">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jenis Produk</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cek = null;
                                        foreach ($result as $cek => $row) {
                                            echo '
                                                <tr>
                                                    <td>' . $row["jenis"] . '</td>
                                                    <td>' . $row["harga"] . '/lembar</td>
                                                </tr>
                                            ';
                                         }
                                        if (!$cek) echo '
                                            <tr>
                                                <td colspan="2" class="text-center">Produk tidak tersedia</td>
                                            </tr>
                                        ';
                                    ?>
                                   
                                </tbody>
                                
                            </table>
                            <a href="cetak.php?id_agen=<?= $id_agen ?>" class="mb-2 mt-2 btn btn-block btn-lg btn-success">Cetak Disini</a>
                        </form>
                    </div>
                </div>
            </div>
            ';

        </div>
    </div>

</div>
</div>
</div>
</div>
</div>

<?php
require('template/footer.php');
?>