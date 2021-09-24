<?php
require ('template/header.php');

$result = marchent();
?>

<div class="app-main__outer">
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
                <?php foreach ($result as $i => $row) { ?>
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
                                    <a href="cek_antrian.php?id=<?= $row['id'] ?>" class="col-sm-9 mx-2 btn btn-primary btn-block">Kunjungi</a>
                                    <button class="btn btn-success col-sm-2"><i class="fa fa-comment"></i></button>
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
                                        <small><i class="fa fa-users"></i> 300</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row["nama_percetakan"] ?></h5>
                                <div id="carouselExampleControls2" class="carousel slide carousel-fade" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" height="250" src="../mitra/img/daftar<?= $row["poto"] ?>" alt="First slide">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p><?= $row["keterangan"] ?></p>
                                                <p><?= $row["alamat"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <a href="cek_antrian.php?id=<?= $row['id'] ?>" class="mb-2 mr-2 btn btn-primary btn-block">Kunjungi</a>
                            </div>
                        </div>
                    </div>  -->  
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    require('template/footer.php');
?>