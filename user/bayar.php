<?php
session_start();
if (!isset($_SESSION["masuk"])) {
    header("Location: login.php");
    exit;
}
require('template/header.php');
?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-wallet icon-gradient bg-plum-plate">
                        </i>
                    </div>
                    <div>Pembayaran
                        <div class="page-title-subheading">Pemesanan pertama anda harus membayar panjar terlebih dahulu dengan nominal setengah atau seperempat dari harga pesanan anda, untuk pemesanan setelahnya, anda tidak wajib membayar panjar dan bebas menentukan metode pembayaran!!!
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Pilih Metode Pembayaran</h5>
                                <form action="">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="position-relative form-check">
                                                <label class="form-check-label">
                                                    <input name="radio1" type="checkbox" value="" class="form-check-input"> Transfer Bank
                                                    <img src="assets/images/bayar/bni.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/logo-bca.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/bri.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/Bank_Syariah_Indonesia.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/bjb.png" alt="" width="50px" height="20px">
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="position-relative form-check">
                                                <label class="form-check-label">
                                                    <input name="radio1" type="checkbox" value="" class="form-check-input"> Dompet Digital
                                                    <img src="assets/images/bayar/dana-logo-png.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/gopay.jpg" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/paypal.png" alt="" width="50px" height="20px">
                                                    <img src="assets/images/bayar/Logo Link Aja!.png" alt="" width="50px" height="20px">

                                                </label>
                                            </div>
                                        </li>
                                        <input placeholder="Nama akun" type="text" class="mb-2 form-control">
                                        <input placeholder="Nominal Pembayaran" type="number" class="mb-2 form-control">
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Ringkasan Pesanan</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">Total Harga Pesanan</li>
                                    <li class="list-group-item">Nominal Pembayaran</li>
                                    <li class="list-group-item">Morbi leo risus</li>
                                    <li class="list-group-item">Porta ac consectetur ac</li>
                                    <li class="list-group-item">Vestibulum at eros</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require('template/footer.php');
        ?>