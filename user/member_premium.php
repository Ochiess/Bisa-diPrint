<?php

require('template/header.php');

$member = mysqli_query($conn, "SELECT * FROM member WHERE user_id='$id'");
$cek = mysqli_fetch_assoc($member);
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="metismenu-icon pe-7s-id icon-gradient bg-deep-blue"></i>
                </div>
                <div>Member Premium</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Member Premium</h5>
            <div style="min-height: 300px;">
                <?php if (!$cek) { ?>
                    <div class="text-center px-5">
                        <h4 class="mt-5"><i>Anda belum menjadi member premium</i></h4>
                        <span>Silahkan gabung jadi member premium untuk menikmati layanan kami, dengan bergabung menjadi member premium anda dapat melakukan percetakan berkali-kali hanya dengan sekali bayar</span><br><br>
                        <a href="#member_premium" class="btn btn-success btn-rounded">Gabung Jadi Member</a>
                    </div>
                <?php } else if ($cek && $cek['status'] == 'regist') { ?>
                    <div class="text-center">
                        <h4 class="mt-3">Selesikan transaksi</h4>
                        <span>Anda telah mendaftar sebgai member premium. Silahkan selesaikan transaksi berikut untuk mengaktifkan paket premium anda!</span>
                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-5">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Paket</td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                if ($cek['topup'] == 20000) echo "Paket Perdana";
                                                else if ($cek['topup'] == 50000) echo "Paket Medium";
                                                else if ($cek['topup'] == 100000) echo "Paket Super";
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td>:</td>
                                            <td>Rp.<?= number_format($cek['topup']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" id="bayar" data-token="<?= $cek['payment_token'] ?>" data-kode="<?= $cek['payment_id'] ?>">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                <?php } else if ($cek && ($cek['status'] == 'active' || $cek['status'] == 'renew')) { ?>
                    <div class="text-center">
                        <h4 class="mt-3">Anda terdaftar sebagai member premium</h4>
                        <span>Terima kasih telah menjadi member peremium kami, silahkan nikmati layanan yang kami sediakan!</span>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-sm-5">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="180"><b>Saldo Anda</b></td>
                                        <td>:</td>
                                        <td><b class="text-success">Rp.<?= number_format($cek['saldo']) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Saldo Digunakan</b></td>
                                        <td>:</td>
                                        <td><b class="text-danger">Rp.<?= number_format($cek['saldo_digunakan']) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Riwayat Pemakaian</b></td>
                                        <td>:</td>
                                        <td>
                                            <?php 
                                            $cek_pakai = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id' AND metode_pembayaran='member'");
                                            $total_pakai = mysqli_num_rows($cek_pakai);
                                            if ($total_pakai > 0) echo $total_pakai."x Pemakaian";
                                            else echo "<i>belum dipakai</i>";
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center">
                        <?php  if ($cek['status'] == 'active') { ?>
                            <a href="#member_premium" class="btn btn-success btn-rounded">Tambah Paket Lainnya</a>
                        <?php } else { ?>
                            <hr>
                            <h4 class="mt-3">Paket Tambahan</h4>
                            <span>Sepertinya and telah melakukan pembelian paket tambahan, silahkan selesaikan transaksi anda!</span>
                            <div class="row justify-content-center mt-3">
                                <div class="col-sm-5">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Paket</td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                    if ($cek['topup'] == 20000) echo "Paket Perdana";
                                                    else if ($cek['topup'] == 50000) echo "Paket Medium";
                                                    else if ($cek['topup'] == 100000) echo "Paket Super";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Harga</td>
                                                <td>:</td>
                                                <td>Rp.<?= number_format($cek['topup']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary" id="bayar" data-token="<?= $cek['payment_token'] ?>" data-kode="<?= $cek['payment_id'] ?>">Bayar Sekarang</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <hr>
            <h5 class="card-title">Pilih Paket Langganan</h5>
            <h5 class="text-center mt-3">Bayar Sekali Print berkali-kali</h5>
            <div class="text-center mb-5">
                Untuk menjadi member premium, silahkan melakukan top up di berbagai paket di bawah ini
            </div>
            <div class="row" id="member_premium">
                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                        <h4 style="text-transform: uppercase">Paket Perdana</h4>
                        <h4 class="mt-2 text-success">Rp. 20.000 </h4>
                        <hr>
                        <button class="btn btn-primary mt-2 top-up" data-price="20000" data-paket="Paket Perdana">TOP UP</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                        <h4 style="text-transform: uppercase">Paket Medium</h4>
                        <h4 class="mt-2 text-success">Rp. 50.000 </h4>
                        <hr>
                        <button class="btn btn-warning mt-2 top-up" data-price="50000" data-paket="Paket Medium">TOP UP</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3 text-center card card-body shadow">
                        <h4 style="text-transform: uppercase">Paket Super</h4>
                        <h4 class="mt-2 text-success">Rp.100.000 </h4>
                        <hr>
                        <button class="btn btn-danger mt-2 top-up" data-price="100000" data-paket="Paket Super">TOP UP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-DAbmO3EFyeXaOTdB"></script>
<script>
    $(document).ready(function() {
        $('#nv-member').addClass('mm-active');

        $('.top-up').click(function(event) {
            var price = $(this).attr('data-price');
            var paket = $(this).attr('data-paket');

            $.ajax({
                url     : 'store.php',
                method  : "POST",
                data    : {
                    user_id: "<?= $id ?>",
                    price: price,
                    paket: paket,
                    req: 'topUp'
                },
                // contentType : false,
                // processData: false,
                success : function(data) {
                    if (data.token) {
                        snap.pay(data.token, {
                            onSuccess: function(result){
                                alert_payment();
                            },
                            onPending: function(result){
                                alert_payment();
                            },
                            onError: function(result){
                                alert_payment();
                            },
                            onClose: function(result){
                                alert_payment();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Selesaikan Pembayaran",
                            icon: "warning",
                            text: "Anda belum menyelesaikan transaksi sebelumnya, mohon segera sdiselesaikan"
                        });
                    }
                }
            });
        });

        $(document).on('click', '#bayar', function(event) {
            var token = $(this).attr('data-token');
            var kode = $(this).attr('data-kode');

            snap.pay(token, {
                onSuccess: function(result){
                    cekStatusPayment(kode);
                },
                onPending: function(result){
                    cekStatusPayment(kode);
                },
                onError: function(result){
                    cekStatusPayment(kode);
                },
                onClose: function(result){
                    cekStatusPayment(kode);
                }
            });
        });

        function alert_payment() {
            Swal.fire({
                title: "Selesaikan Pembayaran",
                icon: "info",
                text: "Silahkan selesaikan pembayaran anda. Transaksi anda akan dibatalkan jika pembayaran tidak dilakuka dalam 1 jam"
            }).then(function() {
                location.href = "member_premium.php";
            });
        }

        function cekStatusPayment(kode) {
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'cekStatusPayment',
                    kode: kode,
                },
                success : function(data) {
                    if (data.transaction_status == "settlement" || data.transaction_status == "capture") {
                        $.ajax({
                            url     : 'controller.php',
                            method  : "POST",
                            data    : {
                                req: 'updateStatusMember',
                                user_id: "<?= $id ?>",
                            },
                            success : function(data) {
                                Swal.fire({
                                    title: "Transaksi Berhasil",
                                    icon: "success",
                                    text: "Terimakasih telah menyelesaikan transaksi, anda sekarang telah menjadi member premium kami"
                                }).then(function() {
                                    location.href = "member_premium.php";
                                });
                            }
                        });    
                    } else {
                        iziToast.info({
                            title: "Selesaikan pembayaran",
                            message: "Silahkan selesaikan pembayaran anda. Transaksi anda akan dibatalkan jika pembayaran tidak dilakuka dalam 1 jam",
                            position: 'topRight'
                        });
                    }
                }
            });
        }
    });
</script>