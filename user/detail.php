<?php
require('template/header.php');
$id_agen = $_GET['id'];
$result = panggil_produk($id_agen);
$agent = mysqli_query($conn, "SELECT * FROM agen WHERE id='$id_agen'");
$agn = mysqli_fetch_assoc($agent);
?>

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
        <div class="col-lg-6">
            <div class="main-card mb-3 card">
                <img class="card-img-top d-block w-100" height="250" src="../mitra/img/daftar<?= $agn["poto"] ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $agn['nama_percetakan'] ?></h5>
                    <h6 class="card-subtitle" style="color: green; font-size: 12px;">Online</h6>
                    <p><i><?= $agn['keterangan'] ?></i></p>
                    <hr>
                    <div class="mb-2">
                        <a href=""><i class="metismenu-icon pe-7s-user"></i></a> <span><?= $agn['nama_pemilik'] ?></span>
                    </div>
                    <div>
                        <i class="fa fa-phone mr-2"></i> <span><?= $agn['telpon'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
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

<?php
require('template/footer.php');
?>

<script>
    $(document).ready(function() {
        $('#nv-find').addClass('mm-active');
    });
</script>