<?php
require('template/header.php');
?>

<!--main content-->
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>Cetak Dokumen</div>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Pengaturan File</h5>
                                <form class="">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Jenis Kertas</label>
                                        <select name="select" id="exampleSelect" class="form-control">
                                            <option>~Pilih Jenis Kertas~</option>
                                            <option>Letter(Kwarto)</option>
                                            <option>A4</option>
                                            <option>F4(Folio)</option>
                                            <option>A3</option>
                                            <option>B5</option>
                                            <option>A5</option>
                                        </select>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="jumlahrangkap" class="">Jumlah Rangkap</label>
                                        <input name="jumlahrangkap" id="jumlahrangkap" placeholder="" type="number" class="form-control">
                                    </div>
                                    <fieldset class="position-relative form-group">
                                        <label for="jumlahrangkap" class="">Warna</label>
                                        <div class="position-relative form-check">
                                            <label class="form-check-label">
                                                <input name="radio1" type="radio" class="form-check-input"> Hitam-Putih
                                            </label>
                                        </div>
                                        <div class="position-relative form-check">
                                            <label class="form-check-label">
                                                <input name="radio1" type="radio" class="form-check-input">
                                                Berwarna
                                            </label>
                                        </div>
                                    </fieldset>
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Halaman</label>
                                        <select name="select" id="exampleSelect" class="form-control">
                                            <option>~Pilih Halaman~</option>
                                            <option>Semua</option>
                                            <option>Pilih Tertentu</option>
                                        </select>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="jumlahrangkap" class="">Jumlah Halaman</label>
                                        <input name="jumlahrangkap" id="jumlahrangkap" placeholder="" type="number" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Waktu Pengambilan</label>
                                        <select name="select" id="exampleSelect" class="form-control">
                                            <option>~Pilih waktu pengambilan~</option>
                                            <!--bagaimana caranya konek dengan waktu saat itu ?-->
                                            <option>Letter(Kwarto)</option>
                                            <option>A4</option>
                                            <option>F4(Folio)</option>
                                            <option>A3</option>
                                            <option>B5</option>
                                            <option>A5</option>
                                        </select>
                                        <small class="form-text text-muted">waktu pengambilan setidaknya lebih dari 10 menit setelah file di kirim
                                        </small>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleText" class="">Catatan Untuk admin</label>
                                        <textarea name="text" id="exampleText" class="form-control" placeholder="Misal : Tolong dijilid dengan warna biru"></textarea>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleFile" class="">File</label>
                                        <input name="file" id="exampleFile" type="file" class="form-control-file">
                                        <small class="form-text text-muted">Demi kenyamanan anda, pastikan file yang anda kirim telah di edit sebelumnya dan berikan arahan yang lengkap kepada admin.
                                        </small>
                                    </div>
                                    <div class="">
                                        <button class="mb-2 mr-2 btn btn-primary pe-7s-calculator"> Cek Harga
                                        </button>
                                        <button class="mb-2 mr-2 btn btn-success pe-7s-paper-plane"> Kirim
                                        </button>
                                        <button class="mb-2 mr-2 btn btn-warning pe-7s-angle-down"><a href="history.php"> Simpan</a>
                                        </button>
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