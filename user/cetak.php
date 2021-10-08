<?php

require ('template/header.php');

//$cetak = query("SELECT * FROM cetak WHERE id='$id'") [0];

$id_agen= $_GET['id_agen'];

if (isset($_POST["kirim"])) {
    if (cetak($_POST)) {
        echo "<script> 
        alert ('Data ditambah');
        </script>";
    }
}
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
            <div class="row">
                <div class="col-md-7">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form class="" action="" method="POST" enctype="multipart/form-data">
                                <h5 class="card-title">Pilih Layanan</h5>
                                <hr>
                                <div class="position-relative form-group row">
                                    <label for="layanan_id" class="col-sm-3">Pilih Jenis Layanan</label>
                                    <div class="col-sm-9">
                                        <select name="layanan_id" id="layanan_id" class="form-control">
                                            <option value="">.::Pilih Layanan::.</option>
                                            <option value="dokumen">Cetak Dokumen</option>
                                            <option value="foto">Cetak Foto</option>
                                        </select>
                                        <small class="form-text text-muted">Silahkan pilih layanan yang anda inginkan diatas!
                                        </small>
                                    </div>
                                </div>
                                <h5 class="card-title mt-4">Pengaturan File & Atribut Layanan</h5>
                                <hr>
                                <div id="cetak-dokumen" style="display: none;">
                                    <div class="position-relative form-group row">
                                        <label for="warna" class="col-sm-3">Warna Tulisan</label>
                                        <div class="col-sm-9">
                                            <input type="radio" checked="" name="warna_tulisan" id="hitamputih" required="required" value="Hitam-Putih"> <label for="hitamputih">Hitam-Putih&nbsp;&nbsp;</label>
                                            <input type="radio" name="warna_tulisan" id="berwarna" required="required" value="Berwarna"> <label for="berwarna">Berwarna</label>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jenis_kertas" class="col-sm-3">Jenis Kertas</label>
                                        <div class="col-sm-9">
                                            <select name="jenis_kertas" id="jenis_kertas" class="form-control">
                                                <option value="">.::Pilih Jenis Kertas::.</option>
                                                <option value="letter">Letter(Kwarto)</option>
                                                <option value="a4">A4</option>
                                                <option value="f4">F4(Folio)</option>
                                                <option value="a3">A3</option>
                                                <option value="b5">B5</option>
                                                <option value="a5">A5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jenis_kertas" class="col-sm-3">Jilid (Optional)</label>
                                        <div class="col-sm-9">
                                            <select name="jenis_kertas" id="jenis_kertas" class="form-control">
                                                <option value="">.::Pilih Jenis Jilid::.</option>
                                                <option value="letter">Letter(Kwarto)</option>
                                                <option value="a4">A4</option>
                                                <option value="f4">F4(Folio)</option>
                                                <option value="a3">A3</option>
                                                <option value="b5">B5</option>
                                                <option value="a5">A5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="exampleFile" class="col-sm-3">Dokumen</label>
                                        <div class="col-sm-9">
                                            <input name="berkas" id="berkas" type="file" class="form-control-file" value="">
                                            <small class="form-text text-muted">Untuk kenyamanan anda, pastikan file yang anda kirim telah di edit sebelumnya dan berikan arahan yang lengkap kepada percetakan.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jumlah_halaman" class="col-sm-3">Jumlah Halaman</label>
                                        <div class="col-sm-9">
                                            <input name="jumlah_halaman" id="jumlah_halaman" type="number" class="form-control" value="jumlah_halaman" placeholder="Jumlah Halaman.." readonly="">
                                            <small class="form-text text-muted">Jumlah halaman akan otomatis dihitung dari file yang anda upload
                                            </small>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jumlah_rangkap" class="col-sm-3">Jumlah Rangkap</label>
                                        <div class="col-sm-9">
                                            <input name="jumlah_rangkap" id="jumlah_rangkap" type="number" class="form-control" placeholder="Jumlah Rangkap..">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="exampleText" class="col-sm-3">Catatan Untuk Pencetak</label>
                                        <div class="col-sm-9">
                                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Misal : Tolong dijilid dengan warna biru"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="cetak-foto" style="display: none;">
                                    <div class="position-relative form-group row">
                                        <label for="ukuran_foto" class="col-sm-3">Ukuran Foto</label>
                                        <div class="col-sm-9">
                                            <select name="ukuran_foto" id="ukuran_foto" class="form-control">
                                                <option value="">.::Pilih Ukuran Foto::.</option>
                                                <option value="letter">Ukuran 2x3</option>
                                                <option value="letter">Ukuran 3x4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="warna" class="col-sm-3">Ganti Latar</label>
                                        <div class="col-sm-9">
                                            <input type="radio" checked="" name="latar" id="ganti_latar" required="required" value="ya"> <label for="ganti_latar">Ya&nbsp;&nbsp;</label>
                                            <input type="radio" name="latar" id="tidak_ganti" required="required" value="Tidak"> <label for="tidak_ganti">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="exampleFile" class="col-sm-3">Dokumen</label>
                                        <div class="col-sm-9">
                                            <input name="berkas" id="berkas" type="file" class="form-control-file" value="">
                                            <small class="form-text text-muted">Untuk kenyamanan anda, pastikan file yang anda kirim telah di edit sebelumnya dan berikan arahan yang lengkap kepada percetakan.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="jumlah_rangkap" class="col-sm-3">Jumlah Rangkap</label>
                                        <div class="col-sm-9">
                                            <input name="jumlah_rangkap" id="jumlah_rangkap" type="number" class="form-control" placeholder="Jumlah Rangkap..">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group row">
                                        <label for="exampleText" class="col-sm-3">Catatan Untuk Pencetak</label>
                                        <div class="col-sm-9">
                                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Misal : Tolong ganti latar biru"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4" id="not-pick">
                                    <h6 class="text-center"><i>Silahkan pilih layanan terlebih dahulu!</i></h6>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Checkout & Set Waktu Pengambilan</h5>
                            <hr>
                            <div class="position-relative form-group">
                                <label for="exampleSelect">Perkiraan Waktu Pengambilan</label>
                                <input name="waktu_pengambilan" id="waktu_pengambilan" type="datetime-local" class="form-control">
                            </div>
                            <hr>
                            <div class="position-relative form-group">
                                <label for="exampleSelect"><b>Total Pembayaran</b></label>
                                <h4 class="text-success"><b>RP.25,000</b></h4>
                            </div>
                            <div class="position-relative form-group">
                                <label for="exampleSelect">Metode Pembayaran</label>
                                <select name="jenis_kertas" id="jenis_kertas" class="form-control">
                                    <option value="langsung">Bayar Langsung</option>
                                    <option value="virtual">Pembayaran Virtual</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-check"></i> Chekout</button>
                        </div>
                    </div>
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

        $('#layanan_id').change(function(event) {
            val = $(this).val();
            if (val=='dokumen') {
                $('#not-pick').hide()
                $('#cetak-foto').hide();
                $('#cetak-dokumen').show();
            } else {
                $('#not-pick').hide()
                $('#cetak-dokumen').hide();
                $('#cetak-foto').show();
            }
        });
    });
</script>