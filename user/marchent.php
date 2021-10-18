<?php
require ('template/header.php');

$result = marchent();
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa  fa-binoculars icon-gradient bg-deep-blue"></i>
                </div>
                <div>Cari Percetakan</div>
            </div>
        </div>
    </div>
    <div class="card-group">
        <div class="row">
            <?php foreach ($result as $i => $row) { 
                $agen_id = $row['id'];
                $pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$agen_id' AND (status != 'finish' AND status != 'cancel')");
                $antrian = mysqli_num_rows($pesanan);
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img class="card-img-top d-block w-100" height="250" src="../mitra/img/daftar<?= $row["poto"] ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row["nama_percetakan"] ?></h5>
                            <div style="font-size: 12.5px;">
                                <div class="mb-2">
                                    <i class="metismenu-icon pe-7s-info text-info"></i> <?= $row["keterangan"] ?>
                                </div>
                                <div class="card-text text-primary">
                                    <i class="metismenu-icon pe-7s-map-marker text-danger"></i> <?= $row["alamat"] ?>
                                </div>
                            </div>
                            <div class="row mt-2" style="margin-bottom: -10px;">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="col-sm-9 mx-2 btn btn-primary btn-block">Kunjungi</a>
                                <button class="btn btn-success col-sm-2 show-chat"><i class="fa fa-comment"></i></button>
                            </div>
                        </div>
                        <div class="card-footer pr-0">
                            <div class="row w-100">
                                <div class="col-md-8">
                                    <?php if($i % 2 == 1) { ?>
                                        <small class="text-muted">Last onlie 3 mins ago </small>
                                    <?php } else { ?>
                                        <small class="text-success">Online</small>
                                    <?php } ?>
                                </div>
                                <div class="col-md-4 text-right">
                                    <small><i class="fa fa-users"></i> <?= $antrian ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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