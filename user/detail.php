<?php
require('template/header.php');
$id_agen = $_GET['id'];
$result = panggil_produk($id_agen);
$agent = mysqli_query($conn, "SELECT * FROM agen WHERE id='$id_agen'");
$agn = mysqli_fetch_assoc($agent);
$config = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$id_agen'");
$cfg = mysqli_fetch_assoc($config);
$pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id_agen' AND (status != 'finish' AND status != 'cancel')");
$antrian = mysqli_num_rows($pesanan);
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
                                <span class="col-sm-11 p-0">&nbsp;<b><?= $antrian ?> Antrian</b></span>
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
                    
                    <?php if ($cfg['cetak_dokumen'] == '1') { ?>
                        <table class="mb-2 table table-bordered">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <td colspan="3">
                                        <h6><b>Cetak Dokumen</b></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Atribut</th>
                                    <th>Item</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Warna Tulisan</td>
                                    <td>
                                        1. Hitam-Putih<br>
                                        2. Berwarna<br>
                                    </td>
                                    <td>
                                        <?php 
                                        $warna_tulisan = mysqli_query($conn, "SELECT * FROM warna_tulisan WHERE agen_id='$id_agen'");
                                        $wrt = mysqli_fetch_assoc($warna_tulisan);
                                        echo 'Rp.'.number_format($wrt['hitam_putih']).'/lembar<br>';
                                        echo 'Rp.'.number_format($wrt['berwarna']).'/lembar<br>';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php 
                                    $jenis_kertas = mysqli_query($conn, "SELECT * FROM jenis_kertas WHERE agen_id='$id_agen'");
                                    ?>
                                    <td>Jenis Kertas</td>
                                    <td>
                                        <?php 
                                        $no=1;
                                        foreach ($jenis_kertas as $jnk) {
                                            echo $no.'. '.$jnk['jenis_kertas'].'<br>';
                                            $no++;
                                        } ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $no=1;
                                        foreach ($jenis_kertas as $jnk) {
                                            echo $jnk['harga'] ? 'Rp.'.number_format($jnk['harga']).'/lembar' : '-';
                                            echo '<br>';
                                            $no++;
                                        } ?>
                                    </td>
                                </tr>
                                <?php if ($cfg['jilid'] == '1') {
                                    $jilid = mysqli_query($conn, "SELECT * FROM jilid WHERE agen_id='$id_agen'"); 
                                    if (mysqli_num_rows($jilid) > 0) { ?>
                                        <tr>
                                            <td>Jilid</td>
                                            <td>
                                                <?php 
                                                $no=1;
                                                foreach ($jilid as $jld) {
                                                    echo $no.'. '.$jld['item'].'<br>';
                                                    $no++;
                                                } ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $no=1;
                                                foreach ($jilid as $jld) {
                                                    echo $jld['harga'] ? 'Rp.'.number_format($jld['harga']) : '-';
                                                    echo '<br>';
                                                    $no++;
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    <?php } 
                    if ($cfg['cetak_foto'] == '1') { ?>
                        <table class="mb-2 table table-bordered">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <td colspan="3">
                                        <h6><b>Cetak Foto</b></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Atribut</th>
                                    <th>Item</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php 
                                    $ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE agen_id='$id_agen'");
                                    ?>
                                    <td>Ukuran Foto</td>
                                    <td>
                                        <?php 
                                        $no=1;
                                        foreach ($ukuran_foto as $jnk) {
                                            echo $no.'. '.$jnk['ukuran'].'<br>';
                                            $no++;
                                        } ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $no=1;
                                        foreach ($ukuran_foto as $jnk) {
                                            echo $jnk['harga'] ? 'Rp.'.number_format($jnk['harga']).'/lembar' : '-';
                                            echo '<br>';
                                            $no++;
                                        } ?>
                                    </td>
                                </tr>
                                <?php if ($cfg['latar'] == '1') { ?>
                                    <tr>
                                        <td>Ganti Latar</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } 
                    if ($cfg['cetak_dokumen'] == '0' && $cfg['cetak_foto'] == '0') { ?>
                        <div class="text-center">
                            <h6 class="text-center mt-4"><i>Tidak ada layanan di, silahkan pilih tempat lain!</i></h6>
                            <a href="marchent.php" class="mb-2 mt-2 btn btn-block btn-lg btn-link"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                        </div>
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