<?php
require('template/header.php');

$result = marchent();

if (isset($_GET['key'])) {
    $key = $_GET['key'];
    $result = mysqli_query($conn, "SELECT * FROM agen WHERE status='active' AND nama_percetakan LIKE '%$key%'");
}

if (isset($_POST['set_rating'])) {
    $rating = $_POST['rating'];
    $user_id = $_POST['user_id'];
    $agen_id = $_POST['agen_id'];

    $cek_rating = mysqli_query($conn, "SELECT * FROM rating WHERE user_id='$user_id' AND agen_id='$agen_id'");
    $myr = mysqli_fetch_assoc($cek_rating);
    if ($myr) {
        mysqli_query($conn, "UPDATE rating SET rating='$rating' WHERE user_id='$user_id'");
    } else {
        mysqli_query($conn, "INSERT INTO rating VALUES(NULL, '$user_id', '$agen_id', '$rating')");
    }

    $success_rat = true;
}
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
    <div class="">
        <?php if (isset($_GET['key'])) { ?>
            <h4 class="text-center">Hasil Pencarian</h4>
            <hr>
        <?php } ?>
        <div class="row">
            <?php foreach ($result as $i => $row) {
                $agen_id = $row['id'];
                $pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$agen_id' AND (status != 'finish' AND status != 'cancel')");
                $antrian = mysqli_num_rows($pesanan);

                $get_rating = mysqli_query($conn, "SELECT * FROM rating WHERE agen_id='$agen_id'");
                $count_rat = mysqli_num_rows($get_rating);
                $get_rat = 0;
                foreach ($get_rating as $rat) {
                    $get_rat = $get_rat + $rat['rating'];
                }

                if ($get_rat > 0) $rating = $get_rat / $count_rat;
                else $rating = 0;
            ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img class="card-img-top d-block w-100" height="250" src="../mitra/img/daftar<?= $row["poto"] ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $row["nama_percetakan"] ?>
                                <div style="margin-bottom: -10px; font-size: 11px;">
                                    <?php
                                    for ($i = 1; $i <= $rating; $i++) {
                                    ?>
                                        <span class="text-warning"><i class="fa fa-star fa-sm"></i></span>
                                        <?php }
                                    if ($rating != 0 && $rating != 1 && $rating != 2 && $rating != 3 && $rating != 4 && $rating != 5) {
                                        if (round($rating) == $rating) { ?>
                                            <span class="text-light"><i class="fa fa-star fa-sm"></i></span>
                                        <?php } else { ?>
                                            <span class="text-warning"><i class="fa fa-star-half-alt fa-sm"></i></span>
                                        <?php }
                                    }
                                    for ($i = $rating + 1; $i <= 5; $i++) {
                                        ?>
                                        <span class="text-light"><i class="fa fa-star fa-sm"></i></span>
                                    <?php } ?>
                                    <span style="text-transform: lowercase;"><?= ($rating == round($rating) ? round($rating, 1) . '.0' : round($rating, 1)) . ' (' . $count_rat . ')' ?></span>
                                </div>
                            </h5>
                            <div style="font-size: 12.5px;" class="mt-2">
                                <div class="mb-2">
                                    <i class="metismenu-icon pe-7s-info text-info"></i> <?= $row["keterangan"] ?>
                                </div>
                                <div class="card-text text-primary">
                                    <i class="metismenu-icon pe-7s-map-marker text-danger"></i> <?= $row["alamat"] ?>
                                </div>
                            </div>
                            <div class="row mt-2" style="margin-bottom: -10px;">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="col-sm-7 mx-1 btn btn-primary btn-block">Kunjungi</a>
                                <button class="btn btn-warning col-sm-2 mr-1" data-toggle="modal" data-target="#modal-rating<?= $row['id'] ?>"><i class="fa fa-star text-white"></i></button>
                                <button class="btn btn-success col-sm-2 show-chat" data-id="<?= $row["id"] ?>"><i class="fa fa-comment"></i></button>
                            </div>
                        </div>
                        <div class="card-footer pr-0">
                            <div class="row w-100">
                                <div class="col-md-8">
                                    <?php if ($i % 2 == 1) { ?>
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

        <?php if (!isset($i)) { ?>
            <h5 class="text-center mt-5"><i>Percetakan tidak ditemukan</i></h5>
        <?php } ?>
    </div>
</div>
<?php
require('template/footer.php');

foreach ($result as $i => $row) {
    $agen_id = $row['id'];
    $my_rating = mysqli_query($conn, "SELECT * FROM rating WHERE user_id='$id' AND agen_id='$agen_id'");
    $myr = mysqli_fetch_assoc($my_rating);
    $my_rat = 0;
    if ($myr) {
        $my_rat = $myr['rating'];
    }
?>
    <!-- Modal Rating -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-rating<?= $row['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Berikan Penilaian Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form method="post" class="set-rating">
                        <span>Silahkan berikan penilaian untuk <b><?= $row['nama_percetakan'] ?></b></span>
                        <hr>
                        <div class="mt-4 mb-4">
                            <?php for ($i = 1; $i <= $my_rat; $i++) { ?>
                                <a href="#"><i class="rat rat-<?= $i ?> fa fa-star fa-4x text-warning" data-rat="<?= $i ?>"></i></a>
                            <?php } ?>

                            <?php for ($i = $my_rat + 1; $i <= 5; $i++) { ?>
                                <a href="#"><i class="rat rat-<?= $i ?> fa fa-star fa-4x text-light" data-rat="<?= $i ?>"></i></a>
                            <?php } ?>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" name="rating" class="val-rating">
                            <input type="hidden" name="user_id" value="<?= $id ?>">
                            <input type="hidden" name="agen_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="set_rating" class="btn btn-success btn-lg"><i class="fa fa-paper-plane"></i> Kirim Rating</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<script>
    $(document).ready(function() {
        $('#nv-find').addClass('mm-active');

        $('.rat').click(function(e) {
            e.preventDefault();

            var this_rat = $(this).attr('data-rat');
            $(this).parents('.set-rating').find('.rat').removeClass('text-warning').addClass('text-light');
            $(this).parents('.set-rating').find('.val-rating').val(this_rat);
            for (let i = 1; i <= this_rat; i++) {
                $(this).parents('.set-rating').find('.rat-' + i).removeClass('text-light').addClass('text-warning');
            }
        });

        <?php if (isset($success_rat)) { ?>
            iziToast.success({
                title: "Penilaian Terkirim",
                message: "Terima kasih telah memberikan penilaian untuk mitra kami!",
                position: 'topRight'
            });
        <?php } ?>
    });
</script>