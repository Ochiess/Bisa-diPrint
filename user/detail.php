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
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="mb-2 ml-1 row">
                                <span class="col-sm-1 p-0">
                                    <i class="fa fa-user"></i>
                                </span>
                                <span class="col-sm-11 p-0"><?= $agn['nama_pemilik'] ?></span>
                            </div>
                            <div class="mb-2 ml-1 row">
                                <span class="col-sm-1 p-0">
                                    <i class="fa fa-phone"></i>
                                </span>
                                <span class="col-sm-11 p-0"><?= $agn['telpon'] ?></span>
                            </div>
                            <div class="mb-2 ml-1 row">
                                <span class="col-sm-1 p-0">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <span class="col-sm-11 p-0"><?= $agn['email'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2 ml-1 row">
                                <span class="col-sm-1 p-0">
                                    <i class="fa fa-map-marker"></i>
                                </span>
                                <span class="col-sm-11 p-0"><?= $agn['alamat'] ?></span>
                            </div>
                            <div class="mb-2 ml-1 row text-warning">
                                <span class="col-sm-1 p-0">
                                    <i class="fa fa-users"></i>
                                </span>
                                <span class="col-sm-11 p-0">&nbsp;<b>5 Antrian</b></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 pr-1">
                            <a href="marchent.php" class="mb-2 mt-2 btn btn-block btn-lg btn-secondary"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                        </div>
                        <div class="col-md-8 pl-1">
                            <a href="cetak.php?id_agen=<?= $id_agen ?>" class="mb-2 mt-2 btn btn-block btn-lg btn-success"><b><i class="fa fa-print"></i>&nbsp; Cetak Disini</b></a>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="main-card card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Daftar Layanan</h5>
                    <?php 
                    $layanan = mysqli_query($conn, "SELECT * FROM layanan WHERE agen_id='$id_agen'");
                    foreach ($layanan as $lyn) { ?>
                        <table class="mb-2 table table-bordered">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <td colspan="3">
                                        <h6><b><?= $lyn['nama_layanan'] ?></b></h6>
                                        <span><?= $lyn['keterangan'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Atribut</th>
                                    <th>Item</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $ly_id = $lyn['id'];
                                $atribut = mysqli_query($conn, "SELECT * FROM atribut_layanan WHERE layanan_id='$ly_id'");
                                foreach ($atribut as $atr) {
                                    $atr_id = $atr['id'];
                                    $items = mysqli_query($conn, "SELECT * FROM item_layanan WHERE atribut_id='$atr_id'");
                                    ?>
                                    <tr>
                                        <td><?= $atr['nama_atribut'] ?></td>
                                        <td>
                                            <?php 
                                            $no=1;
                                            if ($atr['item'] == 0) echo '-';
                                            else {
                                                foreach ($items as $itm) {
                                                    echo $no.'. '.$itm['item_pilihan'].'<br>';
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if ($atr['item'] == 0) {
                                                echo $atr['harga'] ? 'Rp.'.number_format($atr['harga']) : '-';
                                            } else {
                                                foreach ($items as $itm) {
                                                    $satuan = ($itm['satuan'] != '') ? '/'.$itm['satuan'] : '';
                                                    echo $itm['harga'] ? 'Rp.'.number_format($itm['harga']).$satuan.'<br>' : '-<br>';
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
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