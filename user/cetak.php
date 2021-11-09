<?php

require ('template/header.php');

$id_agen= $_GET['id_agen'];

$jenis_kertas = mysqli_query($conn, "SELECT * FROM jenis_kertas WHERE agen_id='$id_agen'");
$jilid = mysqli_query($conn, "SELECT * FROM jilid WHERE agen_id='$id_agen'");
$ukuran_foto = mysqli_query($conn, "SELECT * FROM ukuran_foto WHERE agen_id='$id_agen'");
$warna_tulisan = mysqli_query($conn, "SELECT * FROM warna_tulisan WHERE agen_id='$id_agen'");
$wrt = mysqli_fetch_assoc($warna_tulisan);

$config = mysqli_query($conn, "SELECT * FROM setting_agen WHERE agen_id='$id_agen'");
$cfg = mysqli_fetch_assoc($config);
?>

<!--main content-->
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-keyboard icon-gradient bg-deep-blue"></i>
                </div>
                <div>Cetak Dokumen</div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <form class="" action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-7">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Pilih Layanan</h5>
                                <hr>
                                <div class="position-relative form-group row">
                                    <label for="layanan" class="col-sm-3">Pilih Jenis Layanan</label>
                                    <div class="col-sm-9">
                                        <select name="layanan" id="layanan" class="form-control" required="">
                                            <option value="">.::Pilih Layanan::.</option>
                                            <?php if ($cfg['cetak_dokumen'] == '1') { ?>
                                                <option value="dokumen">Cetak Dokumen</option>
                                            <?php } 
                                            if ($cfg['cetak_foto'] == '1') { ?>
                                                <option value="foto">Cetak Foto</option>
                                            <?php } ?>
                                        </select>
                                        <small class="form-text text-muted">Silahkan pilih layanan yang anda inginkan diatas!
                                        </small>
                                    </div>
                                </div>
                                <h5 class="card-title mt-4">Pengaturan File & Atribut Layanan</h5>
                                <hr>
                                <div class="cetak-dokumen" style="display: none;">
                                    <div class="position-relative form-group row">
                                        <label for="warna" class="col-sm-3">Warna Tulisan</label>
                                        <div class="col-sm-9">
                                            <input type="radio" checked="" name="warna_tulisan" class="warna_tulisan" data-harga="<?= $wrt['hitam_putih'] ?>" id="hitamputih" value="Hitam-Putih"> <label for="hitamputih">Hitam-Putih&nbsp;&nbsp;</label>
                                            <input type="radio" name="warna_tulisan" class="warna_tulisan" data-harga="<?= $wrt['berwarna'] ?>" id="berwarna" value="Berwarna"> <label for="berwarna">Berwarna</label>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jenis_kertas" class="col-sm-3">Jenis Kertas</label>
                                        <div class="col-sm-9">
                                            <select name="jenis_kertas" id="jenis_kertas" class="form-control" required="">
                                                <option value="">.::Pilih Jenis Kertas::.</option>
                                                <?php foreach ($jenis_kertas as $dta) { ?>
                                                    <option value="<?= $dta['id'] ?>"><?= $dta['jenis_kertas'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if ($cfg['jilid'] == '1' && mysqli_num_rows($jilid) > 0) { ?>
                                        <div class="position-relative form-group row">
                                            <label for="jilid" class="col-sm-3">Jilid (Optional)</label>
                                            <div class="col-sm-9">
                                                <select name="jilid" id="jilid" class="form-control">
                                                    <option value="">.::Pilih Jenis Jilid::.</option>
                                                    <?php foreach ($jilid as $dta) { ?>
                                                        <option value="<?= $dta['id'] ?>"><?= $dta['item'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="jilid" value="0">
                                    <?php } ?>
                                    <div class="position-relative form-group row">
                                        <label for="exampleFile" class="col-sm-3">Dokumen</label>
                                        <div class="col-sm-9">
                                            <input name="dokumen" id="dokumen" type="file" class="form-control-file" required="">
                                            <small class="form-text text-muted">Untuk kenyamanan anda, pastikan file yang anda kirim telah di edit sebelumnya dan berikan arahan yang lengkap kepada percetakan.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jumlah_halaman" class="col-sm-3">Jumlah Halaman</label>
                                        <div class="col-sm-9">
                                            <input name="jumlah_halaman" id="jumlah_halaman" type="number" class="form-control" placeholder="Jumlah Halaman.." readonly="" required="">
                                            <small class="form-text text-muted">Jumlah halaman akan otomatis dihitung dari file yang anda upload
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="cetak-foto" style="display: none;">
                                    <div class="position-relative form-group row">
                                        <label for="ukuran_foto" class="col-sm-3">Ukuran Foto</label>
                                        <div class="col-sm-9">
                                            <select name="ukuran_foto" id="ukuran_foto" class="form-control" required="">
                                                <option value="">.::Pilih Ukuran Foto::.</option>
                                                <?php foreach ($ukuran_foto as $dta) { ?>
                                                    <option value="<?= $dta['id'] ?>"><?= $dta['ukuran'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if ($cfg['latar'] == '1') { ?>
                                        <div class="position-relative form-group row">
                                            <label for="latar" class="col-sm-3">Ganti Latar</label>
                                            <div class="col-sm-9">
                                                <input type="radio" checked="" name="ganti_latar" id="ganti_latar" value="Ya"> <label for="ganti_latar">Ya&nbsp;&nbsp;</label>
                                                <input type="radio" name="ganti_latar" id="tidak_ganti" value="Tidak"> <label for="tidak_ganti">Tidak</label>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="ganti_latar" value="Tidak">
                                    <?php } ?>
                                    <div class="position-relative form-group row">
                                        <label for="exampleFile" class="col-sm-3">Upload Foto</label>
                                        <div class="col-sm-9">
                                            <div class="text-center ml-2">
                                                <div style="width: 100%; height: 5.5cm; border: dashed 2px grey; border-radius: 4px; background-color: #ffee;">
                                                    <h4 class="mt-5 pt-4" id="ket-upload"><i>Silahkan pilih foto</i></h4>
                                                    <img src="" style="height: 100%;" id="thumb-poto">
                                                </div>
                                                <div style="margin-top: 5px; margin-bottom: 10px;">
                                                    <label class="btn btn-sm btn-secondary" for="btn_poto"><i class="fa fa-upload"></i> Upload Foto</label>
                                                    <input type="file" name="foto" id="btn_poto" style="display: none;" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-added" style="display: none;">
                                    <div class="position-relative form-group row">
                                        <label for="jumlah_rangkap" class="col-sm-3">Jumlah Rangkap</label>
                                        <div class="col-sm-9">
                                            <input name="jumlah_rangkap" id="jumlah_rangkap" type="number" class="form-control" value="1" placeholder="Jumlah Rangkap.." required="">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="exampleText" class="col-sm-3">Catatan Untuk Pencetak</label>
                                        <div class="col-sm-9">
                                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Misal : Tolong dijilid dengan warna biru, Tolong ganti latar biru"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 not-pick">
                                    <h6 class="text-center"><i>Silahkan pilih layanan terlebih dahulu!</i></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Checkout & Set Waktu Pengambilan</h5>
                                <hr>
                                <div class="position-relative form-group">
                                    <label for="exampleSelect">Waktu Pengambilan</label>
                                    <input name="waktu_pengambilan" id="waktu_pengambilan" type="datetime-local" class="form-control" required="">
                                </div>
                                <hr>
                                <div class="position-relative form-group">
                                    <label><b>Detail Pembayaran</b></label>
                                    <div style="font-size: 12px;">
                                        <div class="row cetak-dokumen" style="display: none;">
                                            <label class="col-sm-6">Warna Tulisan (<span id="warnaTulisan">Hitam-Putih</span>)</label>
                                            <label class="col-sm-6 pl-0">
                                                <div class="mb-2">
                                                    = Rp.<span id="hargaWrt"><?= $wrt['hitam_putih'] ?></span> 
                                                    x <span class="jumHalaman">0</span> lembar<br>
                                                </div>
                                                <div>
                                                    = Rp.<span id="totalHargaWrt">0</span>
                                                </div>
                                            </label>

                                            <label class="col-sm-6">Jenis Kertas <span id="jenisKertas"></span></label> 
                                            <label class="col-sm-6 pl-0">
                                                <div class="mb-2">
                                                    = Rp.<span id="hargaKertas">0</span> x <span class="jumHalaman">0</span> lembar
                                                </div>
                                                <div>
                                                    = Rp.<span id="totalHargaKertas">0</span>
                                                </div>
                                            </label>

                                            <label class="col-sm-6">Jilid <span id="jenisJilid"></span></label>
                                            <label class="col-sm-6 pl-0">= Rp.<span id="hargaJilid">0</span></label>

                                            <label class="col-sm-6">Sub Total</label>
                                            <label class="col-sm-6 pl-0">= Rp.<span id="subTotal">0</span></label>

                                            <label class="col-sm-6">Jumlah Rangkap(x<span id="jumRangkap">1</span>)</label>
                                            <label class="col-sm-6 pl-0">= Rp.<span class="totalHarga">0</span></label>
                                        </div>

                                        <div class="row cetak-foto" style="display: none;">
                                            <label class="col-sm-6">Ukuran Foto <span id="ukuranFoto"></span></label>
                                            <label class="col-sm-6 pl-0">= Rp.<span id="hargaUkuran">0</span> x <span id="jumlahFoto">1</span> lembar</label>
                                            <label class="col-sm-6">Sub Total</label>
                                            <label class="col-sm-6 pl-0">= Rp.<span id="totalHargaUkuran">0</span></label>
                                        </div>

                                        <div class="not-pick">
                                            <p><i>Belum ada detail pembayaran</i></p>
                                        </div>
                                    </div>
                                    <label><b>Total Pembayaran</b></label>
                                    <h4 class="text-success"><b><i>RP.<span class="totalHarga">0</span></i></b></h4>
                                    <input type="hidden" name="harga" class="totalHarga">
                                </div>
                                <div class="position-relative form-group">
                                    <?php
                                    $cek_pesanan = mysqli_query($conn, "SELECT * FROM cetak WHERE user_id='$id'");
                                    $first = true;
                                    if (mysqli_num_rows($cek_pesanan) > 0) $first = false;
                                    $d_pl = false;
                                    $d_pv = false;
                                    if ($first || $cfg['pembayaran_langsung'] == 0) $d_pl = true;
                                    if (!$first && $cfg['pembayaran_virtual'] == 0) $d_pv = true;
                                    ?>
                                    <label for="exampleSelect">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
                                        <option value="langsung" <?= $d_pl ? 'disabled' : '' ?>>Bayar Langsung</option>
                                        <option value="virtual" <?= $d_pv ? 'disabled' : '' ?>>Pembayaran Virtual</option>
                                    </select>
                                    <?php if ($first) { ?>
                                        <small class="form-text text-muted text-justify">Sepertinya ini pesanan pertama anda. Untuk mengantisipasi pesanan fiktif silahkan menyelesaikan pembayaran dengan metode <b>Pembayaran Virtual</b>. Kenapa ini berlaku? baca <a href="#" target="_blank">Syarat & Ketentuan</a> </small>
                                    <?php } ?>
                                </div>
                                <input type="hidden" name="user_id" value="<?= $id ?>">
                                <input type="hidden" name="agen_id" value="<?= $id_agen ?>">
                                <input type="hidden" name="req" value="storeData">
                                <button type="submit" class="btn btn-primary btn-block btn-lg btn-wait"><i class="fa fa-check"></i> Chekout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-DAbmO3EFyeXaOTdB"></script>
<script>
    $(document).ready(function() {
        $('#nv-find').addClass('mm-active');

        $('#layanan').change(function(event) {
            val = $(this).val();
            if (val=='dokumen') {
                $('.not-pick').hide();
                $('.cetak-foto').hide();
                $('.cetak-dokumen').show();
                $('.form-added').show();
            } else if (val=='foto') {
                $('.not-pick').hide();
                $('.cetak-dokumen').hide();
                $('.cetak-foto').show();
                $('.form-added').show();
            } else {
                $('.cetak-foto').hide();
                $('.cetak-dokumen').hide();
                $('.not-pick').show();
                $('.form-added').hide();
            }
            resetForm(val);
        });

        // Change Warna Tulisan
        $('.warna_tulisan').change(function(event) {
            var harga = $(this).attr('data-harga');
            $('#hargaWrt').text(harga);
            countPriceDokumen();
        });

        // Change Jenis Kertas
        $('#jenis_kertas').change(function(event) {
            var id = $(this).val();
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'getJenisKertas',
                    id: id
                },
                success : function(data) {
                    $('#jenisKertas').text('('+data.jenis_kertas+')');
                    $('#hargaKertas').text(data.harga);
                    countPriceDokumen();
                }
            });
        });

        // Change Jenis Jilid
        $('#jilid').change(function(event) {
            var id = $(this).val();
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'getJenisJilid',
                    id: id
                },
                success : function(data) {
                    $('#jenisJilid').text('('+data.item+')');
                    $('#hargaJilid').text(data.harga);
                    countPriceDokumen();
                }
            });

            if ($(this).val() == '') {
                $('#jenisJilid').text('');
                $('#hargaJilid').text('0');
                countPriceDokumen();
            }
        });

        // Change Ukuran Foto
        $('#ukuran_foto').change(function(event) {
            var id = $(this).val();
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                data    : {
                    req: 'getUkuranFoto',
                    id: id
                },
                success : function(data) {
                    $('#ukuranFoto').text('('+data.ukuran+')');
                    $('#hargaUkuran').text(data.harga);
                    countPriceFoto();
                }
            });

            if ($(this).val() == '') {
                $('#jenisJilid').text('');
                $('#hargaJilid').text('0');
                countPriceFoto();
            }
        });

        // Set Jumlah Rangkap
        $('#jumlah_rangkap').blur(function(event) {
            var val = $('#jumlah_rangkap').val();
            if (val < 1) {
                $('#jumlah_rangkap').val(1);
                $('#jumRangkap').text(1);
                $('#jumlahFoto').text(1);
                $(this).focus();
            }
            if ($('#layanan').val() == 'dokumen') countPriceDokumen();
            else countPriceFoto();
        });
        $('#jumlah_rangkap').keyup(function(event) {
            $('#jumRangkap').text($(this).val());
            $('#jumlahFoto').text($(this).val());
            if ($(this).val() < 1) {
                $('#jumRangkap').text(1);
                $('#jumlahFoto').text(1);
            }
            if ($('#layanan').val() == 'dokumen') countPriceDokumen();
            else countPriceFoto();
        });

        // Upload Dokumen
        $('#dokumen').change(function(event) {
            var dokumen = $(this).prop('files')[0];
            var check = 0;
            var ext = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/msword'];

            $.each(ext, function(key, val) {
                if (dokumen.type == val) check = check + 1;
            });
            if (check == 1) {
                if (dokumen.size > 5120000) {
                    alert('Ukuran file terlalu besar. File harus maksimal 5 MB');
                    $(this).val('');
                    return;
                }
                getNumberOfPage(dokumen);
            } else {
                alert('Format file tidak dibolehkan, pilih file berekstensi .docx, .doc, atau .pdf');
                $(this).val('');
                return;
            } 
        });

        // Upload Foto
        $('#btn_poto').change(function(e) {
            var foto_add = $(this).prop('files')[0];
            var check = 0;
            var ext = ['image/jpeg', 'image/png', 'image/bmp'];

            $.each(ext, function(key, val) {
                if (foto_add.type == val) check = check + 1;
            });

            if (check == 1) {
                if (foto_add.size > 2048000) {
                    alert('Ukuran file terlalu besar. File harus maksimal 2 MB');
                    $(this).val('');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumb-poto').attr('src', e.target.result);
                    $('#ket-upload').hide();
                }
                reader.readAsDataURL(foto_add);
            } else {
                alert('Format file tidak dibolehkan, pilih file berekstensi .jpg, .jpeg, atau .png');
                $('#btn_poto').val('');
                return;
            }
        });

        // Store Data
        $('form').submit(function(event) {
            event.preventDefault();
            $('.btn-wait').attr('disabled', '').find('.fa').removeClass('fa-check').addClass('fa-spinner fa-spin');

            var data = new FormData($(this)[0]);
            $.ajax({
                url     : 'store.php',
                method  : "POST",
                data    : data,
                contentType : false,
                processData: false,
                success : function(data) {
                    if (data.token) {
                        createMessage(data.agen_id, 'virtual_pay');
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
                        createMessage(data.agen_id, 'live_pay');
                        Swal.fire({
                            title: "Pesanan Anda Sedang Diproses",
                            icon: "success",
                            text: "Anda akan mendapatkan notifikasi jika pesanan anda telah selesai diproses"
                        }).then(function() {
                            location.href = "data_pesanan.php";
                        });
                    }
                }
            });
        });

        function alert_payment() {
            Swal.fire({
                title: "Selesaikan Pembayaran",
                icon: "info",
                text: "Silahkan selesaikan pembayaran anda. Pesanan akan dibatalkan jika pembayaran tidak dilakuka dalam 1 jam"
            }).then(function() {
                location.href = "data_pesanan.php";
            });
        }

        function getNumberOfPage(file) {
            var form_data = new FormData();
            form_data.append('file', file);
            form_data.append('req', 'getNumberPage');
            $.ajax({
                url     : 'controller.php',
                method  : "POST",
                cache: false,
                contentType: false,
                processData: false,
                data    : form_data,
                success : function(data) {
                    $('#jumlah_halaman').val(data);
                    $('.jumHalaman').text(data);
                    countPriceDokumen();
                }
            });
        }

        function countPriceDokumen() {
            var jumhalaman = $('#jumlah_halaman').val() ? $('#jumlah_halaman').val() : 0;
            var jumlahrangkap = $('#jumlah_rangkap').val() ? $('#jumlah_rangkap').val() : 1;

            // warna tulisan
            var hargawrt = $('#hargaWrt').text();
            var totalhargawrt = hargawrt*jumhalaman;
            $('#totalHargaWrt').text(totalhargawrt);

            // jenis kertas
            var hargakertas = $('#hargaKertas').text();
            var totalhargakertas = hargakertas*jumhalaman;
            $('#totalHargaKertas').text(totalhargakertas);

            // jenis jilid
            var hargajilid = parseInt($('#hargaJilid').text());

            var subtotal = totalhargawrt+totalhargakertas+hargajilid;
            $('#subTotal').text(subtotal);

            $('.totalHarga').text(subtotal*jumlahrangkap);
            $('.totalHarga').val(subtotal*jumlahrangkap);
        }

        function countPriceFoto() {
            var jumlahrangkap = $('#jumlah_rangkap').val() ? $('#jumlah_rangkap').val() : 1;
            // ukuran foto
            var hargaukuran = $('#hargaUkuran').text();
            var totalhargaukuran = hargaukuran*jumlahrangkap;
            $('#totalHargaUkuran').text(totalhargaukuran);
            $('.totalHarga').text(totalhargaukuran);
            $('.totalHarga').val(totalhargaukuran);
        }

        function resetForm(val) {
            $('form')[0].reset();
            $('#thumb-poto').removeAttr('src');
            $('#ket-upload').show();
            $('#layanan').val(val);

            // reset detail
            $('#warnaTulisan').text('Hitam-Putih');
            $('#hargaWrt').text("<?= $wrt['hitam_putih'] ?>");
            $('.jumHalaman, .totalHarga, #totalHargaWrt, #hargaKertas, #totalHargaKertas, #hargaJilid, #subTotal, #hargaUkuran, #totalHargaUkuran').text('0').val('0');
            $('#jumRangkap, #jumlahFoto').text('1');
            $('#jenisKertas, #jenisJilid, #ukuranFoto').text('');

            // disabled require
            if (val == 'dokumen') {
                $('#jenis_kertas, #dokumen, #jumlah_halaman').attr('required', '');
                $('#ukuran_foto, #btn_poto').removeAttr('required');
            } else {
                $('#ukuran_foto, #btn_poto').attr('required', '');
                $('#jenis_kertas, #dokumen, #jumlah_halaman').removeAttr('required');
            }
        }
    });
</script>