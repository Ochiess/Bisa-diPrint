<?php
require('../function.php');
session_start();

if (isset($_SESSION["masuk_mitra"])) {
    $id = $_SESSION["id_mitra"];

    $getProfile = mysqli_query($conn, "SELECT * FROM agen WHERE id = '$id'");
    $mtr = mysqli_fetch_assoc($getProfile);
    $poto = $mtr["poto"];
    $nama_percetakan = $mtr["nama_percetakan"];
    $alamat = $mtr["alamat"];
    $telpon = $mtr["telpon"];
} else {
    header("Location: login.php");
    exit;
}

$get_pesanan_ = mysqli_query($conn, "SELECT * FROM cetak WHERE agen_id='$id' AND status='panding'");
foreach ($get_pesanan_ as $dta) {
    $waktu_pesanan = strtotime($dta['waktu_pesanan']);
    $waktu_sekrng = strtotime(date('Y-m-d H:i:s'));

    if ($waktu_pesanan + 3600 < $waktu_sekrng) {
        $id_updt = $dta['id'];
        mysqli_query($conn, "UPDATE cetak SET status='cancel' WHERE id='$id_updt'");
    }
}

$res_tarik_saldo = false;
if (isset($_POST['tarik_saldo'])) {
    $jumlah = $_POST['jumlah'];
    $my_saldo = mysqli_query($conn, "SELECT * FROM virtual_payment WHERE agen_id='$id'");
    $sld = mysqli_fetch_assoc($my_saldo);
    $saldo_akun = $sld['saldo_akun'] - $jumlah;
    $saldo_diambil = $sld['saldo_diambil'] + $jumlah;

    if ($saldo_akun > $jumlah || $jumlah == 0) {
        echo "<script>
        alert('Maaf, Saldo anda tidak mencukupi atau nominal salah.');
        window.location.href=window.location.href;
        </script>";
        exit();
    }

    mysqli_query($conn, "UPDATE virtual_payment SET saldo_akun='$saldo_akun', saldo_diambil='$saldo_diambil' WHERE agen_id='$id'");
    $res_tarik_saldo = true;
}

$my_saldo = mysqli_query($conn, "SELECT * FROM virtual_payment WHERE agen_id='$id'");
$sld = mysqli_fetch_assoc($my_saldo);
$config = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$id'");
$cfg = mysqli_fetch_assoc($config);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>diPrint-mitra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="./../layout/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="./assets/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="./../assets/izitoast/css/iziToast.min.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div>
                    <img src="../assets/img/jadi.png" alt="" width="70%" height="60%">
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                    <!-- <div class="search-wrapper">
                    <div class="input-holder">
                        <input type="text" name="keywoard" class="search-input" placeholder="Cari Tempat Percetakan disini">
                        <button class="search-icon" type="submit" name="cari"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div> -->
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <div class="d-inline-block dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-link-icon fa fa-bell"> </i>
                                    Notifikasi
                                    <small><span class="badge badge-pill badge-danger countNotif" style="padding: 5px 0 5px 0;" hidden="">0</span></small>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-131px, 33px, 0px); width: 350px;">
                                    <div class="px-3 py-2">
                                        <span class="badge badge-success pull-right new-notif">New 0</span>
                                        <b>NOTIFIKASI</b>
                                    </div>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <div class="p-0" style="margin-top: -10px;">
                                        <div class="scroll-area-md" style="margin-bottom: -10px;">
                                            <div class="scrollbar-container">
                                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                                    <tbody id="notifContent">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="d-inline-block dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-link-icon fa fa-envelope"> </i>
                                    Pesan
                                    <small><span class="badge badge-pill badge-danger countMessage" style="padding: 5px 0 5px 0;" hidden="">0</span></small>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-131px, 33px, 0px); width: 350px;">
                                    <div class="px-3 py-2">
                                        <span class="badge badge-success pull-right new-message">New <span class="countMessage">0</span></span>
                                        <b>PESAN</b>
                                    </div>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <div class="p-0" style="margin-top: -10px;">
                                        <div class="scroll-area-md" style="margin-bottom: -10px;">
                                            <div class="scrollbar-container">
                                                <table class="align-middle mb-0 table table-border table-hover">
                                                    <tbody id="messsageContent">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php if ($sld) { ?>
                            <li class="nav-item">
                                <div class="d-inline-block dropdown">
                                    <a href="#" class="nav-link text-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="nav-link-icon fa fa-credit-card text-success"></i> <b>Rp.<?= number_format($sld['saldo_akun']) ?></b>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-131px, 33px, 0px); width: 350px;">
                                        <div class="px-3 py-2">
                                            <span class="badge badge-success pull-right">Rp.<?= number_format($sld['saldo_akun']) ?></span>
                                            <b>DETAIL SALDO ANDA</b>
                                        </div>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <div class="p-2" style="margin-top: -10px;">
                                            <small>Info: Semua pembayaran yang dilakukan pelanggan secara virtual atau menggunakan saldo member akan masuk disini!</small>
                                            <div class="p-2">
                                                <b>Total Saldo : </b> <span class="text-success">Rp.<?= number_format($sld['saldo_akun']) ?></span><br>
                                                <b>Saldo Ditarik : </b> <span class="text-danger">Rp.<?= number_format($sld['saldo_diambil']) ?></span><br>

                                                <button class="btn btn-success btn-block btn-pill mt-3" data-toggle="modal" data-target=".modal-tarik-saldo"><i class="fa fa-credit-card"></i> Lakuan Penarikan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn"><img width="42" height="41" class="rounded-circle" src="../mitra/img/daftar<?php echo $poto ?>" alt=""> <i class="fa fa-angle-down ml-2 opacity-8"></i></a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <a type="button" href="profil.php" tabindex="0" class="dropdown-item">Lihat Profil</a>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a type="button" tabindex="0" href="logout.php" class="dropdown-item">Keluar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?php echo $nama_percetakan ?>
                                    </div>
                                    <div class="widget-subheading">
                                        <?php echo $telpon ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Bentuk Sendiri Warnamu</h3>
                        <h3 class="themeoptions-heading">
                            <div>
                                Warna Header
                            </div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                Kembali kewarna default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Pilih Warna
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>warna Sidebar</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                Kembali kewarna default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Pilih Warna
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Menu</li>
                            <li>
                                <a href="index.php" id="nv-beranda">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    Beranda
                                </a>
                            </li>
                            <li>
                                <a href="pesanan.php" id="nv-pesanan">
                                    <i class="metismenu-icon pe-7s-print"></i>
                                    Pesanan Masuk <span class="badge badge-pill badge-danger px-0 py-1 countPesanan" hidden="">0</span>
                                </a>
                            </li>
                            <li>
                                <a href="riwayat.php" id="nv-riwayat">
                                    <i class="metismenu-icon pe-7s-clock"></i>
                                    Riwayat Pesanan
                                </a>
                            </li>
                            <li>
                                <a href="#" id="nv-layanan">
                                    <i class="metismenu-icon pe-7s-note2"></i>
                                    Atur Layanan
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse" id="sub-layanan">
                                    <li>
                                        <a href="cetak_dokumen.php" id="nv-cetak-dokumen">
                                            <i class="metismenu-icon"></i>Cetak Dokumen
                                        </a>
                                    </li>
                                    <li>
                                        <a href="cetak_foto.php" id="nv-cetak-foto">
                                            <i class="metismenu-icon"></i>Cetak Foto
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="pengaturan.php" id="nv-settings">
                                    <i class="metismenu-icon pe-7s-config"></i>
                                    Pengaturan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end header-->
            <div class="app-main__outer">