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
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Pengaturan File</h5>
                            <form class="" action="" method="POST" enctype="multipart/form-data">
                                <div class="position-relative form-group">
                                    <label for="jenis_kertas" class="">Jenis Kertas</label>
                                    <select name="jenis_kertas" id="jenis_kertas" class="form-control">
                                        <option value="">~Pilih Jenis Kertas~</option>
                                        <option value="letter">Letter(Kwarto)</option>
                                        <option value="a4">A4</option>
                                        <option value="f4">F4(Folio)</option>
                                        <option value="a3">A3</option>
                                        <option value="b5">B5</option>
                                        <option value="a5">A5</option>
                                    </select>
                                </div>
                                <div class="position-relative form-group">
                                    <label for="jumlah_rangkap" class="">Jumlah Rangkap</label>
                                    <input name="jumlah_rangkap" id="jumlah_rangkap" type="number" class="form-control">
                                </div>
                                <fieldset class="position-relative form-group">
                                    <label for="warna" class="">Warna</label>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label">
                                            <input name="warna" type="radio" class="form-check-input" value="hitam_putih"> Hitam-Putih
                                        </label>
                                    </div>
                                    <div class="position-relative form-check">
                                        <label class="form-check-label">
                                            <input name="warna" id="berwarna" type="radio" class="form-check-input" value="berwarna">
                                            Berwarna
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Untuk Gambar Atau Logo</small>
                                </fieldset>
                                <div class="position-relative form-group">
                                    <label for="jumlah_halaman" class="">Jumlah Halaman</label>
                                    <input name="jumlah_halaman" id="jumlah_halaman" placeholder="" type="number" class="form-control" value="jumlah_halaman">
                                </div>
                                <div class="position-relative form-group">
                                    <label for="exampleSelect" class="">Perkiraan Waktu Pengambilan</label>
                                    <input name="waktu_pengambilan" id="waktu_pengambilan" type="datetime-local" class="form-control">
                                    <small class="form-text text-muted">waktu selesai cetak akan dihitung oleh sistem berdasarkan antrian yang ada
                                    </small>
                                </div>
                                <div class="position-relative form-group">
                                    <label for="exampleText" class="">Catatan Untuk admin</label>
                                    <textarea name="catatan" id="catatan" class="form-control" placeholder="Misal : Tolong dijilid dengan warna biru"></textarea>
                                </div>
                                <div class="position-relative form-group">
                                    <label for="exampleFile" class="">Dokumen</label>
                                    <input name="berkas" id="berkas" type="file" class="form-control-file" value="">
                                    <small class="form-text text-muted">Untuk kenyamanan anda, pastikan file yang anda kirim telah di edit sebelumnya dan berikan arahan yang lengkap kepada percetakan.
                                    </small>
                                </div>
                                <div class="position-relative form-group">
                                    <label for="exampleText" class="">DISNI TAMPIL HARGA DAN WAKTU SELESAI CETAKNYA</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" ></textarea>
                                </div>
                                <div class="position-relative form-group">
                                    <input type="hidden" name="id_agen" value="<?= $id_agen?>">
                                    <input type="hidden" name="id_user" value="<?= $id?>">
                                    <button type="submit" name="kirim" class="mb-2 mr-2 btn btn-success">KIRIM</button>
                                </div>
                            </form>
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