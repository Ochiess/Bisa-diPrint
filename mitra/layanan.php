<?php

require('template/header.php');

$id = $_SESSION['id_mitra'];
$ly_id = $_GET['layanan_id'];
$success = false;

if (isset($_POST['edit_layanan'])) {
    $nama_layanan = $_POST['nama_layanan'];
    $jenis_file = $_POST['jenis_file'];
    $waktu_kerja = $_POST['waktu_kerja'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama_layanan', jenis_file='$jenis_file', waktu_kerja=' $waktu_kerja', keterangan='$keterangan' WHERE id='$ly_id'");
    $success = true;
}

if (isset($_POST['add_atribut'])) {
    $nama_atribut = $_POST['nama_atribut'];
    $properti = $_POST['properti'];
    $input_warna = $_POST['input_warna'];
    $item = $_POST['item'];
    $waktu_kerja = $_POST['waktu_kerja'] ? $_POST['waktu_kerja'] : 0;
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;

    mysqli_query($conn, "INSERT INTO atribut_layanan VALUES(NULL, '$ly_id', '$nama_atribut', '$properti', '$input_warna', '$item', '$waktu_kerja', '$harga', 'active')");
    $success = true;
}

if (isset($_POST['edit_atribut'])) {
    $id = $_POST['id'];
    $nama_atribut = $_POST['nama_atribut'];
    $properti = $_POST['properti'];
    $input_warna = $_POST['input_warna'];
    $item = $_POST['item'];
    $waktu_kerja = $_POST['waktu_kerja'] ? $_POST['waktu_kerja'] : 0;
    $harga = $_POST['harga'] ? $_POST['harga'] : 0;
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE atribut_layanan SET nama_atribut='$nama_atribut', properti='$properti', input_warna='$input_warna', item='$item', waktu_kerja='$waktu_kerja', harga='$harga', status='$status' WHERE id='$id'");
    if ($item == 0) mysqli_query($conn, "DELETE FROM item_layanan WHERE atribut_id='$id'");
    $success = true;
}

if (isset($_GET['hapus_data'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM atribut_layanan WHERE id='$id'");
    mysqli_query($conn, "DELETE FROM item_layanan WHERE atribut_id='$id'");
    $success = true;
}

$layanan = mysqli_query($conn, "SELECT * FROM layanan WHERE id='$ly_id'");
$ly = mysqli_fetch_assoc($layanan);
$atribut = mysqli_query($conn, "SELECT * FROM atribut_layanan WHERE layanan_id='$ly_id'");
?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note2 icon-gradient bg-deep-blue"></i>
                </div>
                <div>Atur Layanan (<?= $ly['nama_layanan'] ?>)</div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Detail Layanan</h5>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <table class="mb-0 table table-bordered">
                        <tbody>
                            <tr>
                                <td>Nama Layanan</td>
                                <td>:</td>
                                <td><b><?= $ly['nama_layanan'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Jenis File Yang Diupload</td>
                                <td>:</td>
                                <td><b><?= ucwords($ly['jenis_file']) ?></b></td>
                            </tr>
                            <tr>
                                <td>Estimasi Waktu Pengerjaan</td>
                                <td>:</td>
                                <td><b><?= $ly['waktu_kerja'] ?> Menint</b></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><b><?= $ly['keterangan'] ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm mt-2 mb-2" data-toggle="modal" data-target=".modal-edt-layanan"><i class="fa fa-edit"></i> Edit</button>
                </div>
            </div>
            
            <h5 class="card-title mt-4">Atribut Layanan</h5>
            <hr>
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target=".modal-add-atribut"><i class="fa fa-plus-circle"></i> Tambah Atribut Layanan</button>
            <table class="mb-0 table table-bordered" id="dataTable" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th width="1" rowspan="2">No</th>
                        <th rowspan="2">Nama Atribut</th>
                        <th rowspan="2">Properti Inputan</th>
                        <th rowspan="2">Inputan Warna</th>
                        <th colspan="2" class="text-center">Item Atribut & Harga Layanan</th>
                        <th style="font-size: 13px;" rowspan="2">Waktu Kerja <br>Tambahan</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2" width="80">Aksi</th>
                    </tr>
                    <tr>
                        <th width="100">Item</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no=1;
                    foreach($atribut as $atr) {
                        if ($atr['input_warna'] == 1) $warna = '<b class="text-success">Ya</b>';
                        else $warna = '<b class="text-secondary">Tidak</b>';

                        if ($atr['status'] == 'active') $bgcolor = 'badge-success';
                        else if ($atr['status'] == 'nonactive') $bgcolor = 'badge-danger';

                        if ($atr['waktu_kerja']) $waktu = $atr['waktu_kerja'].' Menit';
                        else $waktu = '<i>Tidak Ada</i>';

                        $atr_id= $atr['id'];
                        $item = mysqli_query($conn, "SELECT * FROM item_layanan WHERE atribut_id='$atr_id'");
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $atr['nama_atribut'] ?></td>
                            <td><i><?= ucwords($atr['properti']) ?></i></td>
                            <td class="text-center"><i><?= $warna ?></i></td>
                            <td>
                                <?php
                                if ($atr['item'] == 0) echo '<i>-</i>';
                                else {
                                    $ni = 1;
                                    foreach ($item as $itm) {
                                        echo $ni.'. '. $itm['item_pilihan'].'<br>';
                                        $ni=$ni+1;
                                    }

                                    if ($ni == 1) echo '<i>Belum Diatur</i>';
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($atr['harga'] != 0) echo 'Rp.'.number_format($atr['harga']);
                                else {
                                    $ni = 1;
                                    foreach ($item as $itm) {
                                        if ($itm['harga'] == 0) echo '<i>-</i><br>';
                                        else {
                                            $satuan = $itm['satuan'] ? '/'.$itm['satuan'] : '';
                                            echo 'Rp.'.number_format($itm['harga']).$satuan.'<br>';
                                        }
                                        $ni=$ni+1;
                                    }

                                    if ($ni == 1) echo '<i>-</i>';
                                } ?>
                            </td>
                            <td><?= $waktu ?></td>
                            <td class="text-center">
                                <span class="badge <?= $bgcolor ?>"><?= ucwords($atr['status']) ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($atr['item'] == 1) { ?>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-set-atribut<?= $atr['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Atur Item Atribut"><i class="fa fa-cog"></i></button>
                                <?php } else { ?>
                                    <button class="btn btn-sm btn-primary" disabled="" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Atur Item Atribut"><i class="fa fa-cog"></i></button>
                                <?php } ?>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit<?= $atr['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Edit Atribut"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus<?= $atr['id'] ?>" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Hapus Atribut"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php 
                        $no=$no+1;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require('template/footer.php');
?>

<!-- MODAL EDIT -->
<div class="modal modal-edt-layanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data Layanan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group row">
                        <label class="col-md-4">Nama Layanan</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_layanan" required="required" class="form-control" placeholder="Nama Layanan..." autocomplete="off" value="<?= $ly['nama_layanan'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Jenis File Upload</label>
                        <div class="col-md-8">
                            <?php $berkas = [['dokumen', 'Dokumen (docx, pdf, dll)'], ['foto', 'Foto (png, jpg, dll)']]; ?>
                            <select class="form-control" name="jenis_file" required="">
                                <option value="">--Pilih Jenis Berkas--</option>
                                <?php foreach ($berkas as $bks) { ?>
                                    <option value="<?= $bks[0] ?>" <?php if ($bks[0] == $ly['jenis_file']) echo "selected" ?>><?= $bks[1] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Estimasi Waktu Kerja</label>
                        <div class="col-md-8">
                            <input type="number" name="waktu_kerja" required="required" class="form-control" placeholder="Estimasi Waktu Kerja (Menit)" autocomplete="off" value="<?= $ly['waktu_kerja'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Keterangan</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="keterangan" placeholder="Keterangan..." required=""><?= $ly['keterangan'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" name="edit_layanan" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH LAYANAN -->
<div class="modal modal-add-atribut" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Atribut Layanan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST">
                    <div class="form-group row">
                        <label class="col-md-4">Nama Atribut</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_atribut" required="required" class="form-control" placeholder="Nama Atribut..." autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Properti Inputan</label>
                        <div class="col-md-8">
                            <select class="form-control" name="properti" required="">
                                <option value="required">Required (Wajib)</option>
                                <option value="optional">Optional</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Inputan Warna?</label>
                        <div class="col-md-8">
                            <input type="radio" name="input_warna" id="input_warna1" required="required" value="1"> <label for="input_warna1">Ya&nbsp;&nbsp;</label>
                            <input type="radio" checked="" name="input_warna" id="input_warna2" required="required" value="0"> <label for="input_warna2">Tidak</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Item Atribut</label>
                        <div class="col-md-8">
                            <input type="radio" class="item_atr1" checked="" name="item" id="item_atr1" required="required" value="1"> <label for="item_atr1">Ya&nbsp;&nbsp;</label>
                            <input type="radio" class="item_atr2" name="item" id="item_atr2" required="required" value="0"> <label for="item_atr2">Tidak</label>
                        </div>
                    </div>
                    <div class="form-group row" id="biaya_add">
                        <label class="col-md-4">Biaya Tambahan (Optional)</label>
                        <div class="col-md-8">
                            <input type="number" name="harga" id="harga_add" class="form-control" placeholder="Isi jika ada biaya tambahan untuk atribut ini" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Tambahan Waktu Kerja (Menit)</label>
                        <div class="col-md-8">
                            <input type="number" name="waktu_kerja" class="form-control" placeholder="Tambahan Waktu Kerja (Optional)" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <button type="submit" name="add_atribut" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($atribut as $dta) { ?>
    <!-- MODAL SET ATRIBUT -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-set-atribut<?= $dta['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atur Item Atribut</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body item-content-big">
                        <div class="pl-4 mb-2">
                            <?php 
                            $atr_id = $dta['id'];
                            $cek_items = mysqli_query($conn, "SELECT * FROM item_layanan WHERE atribut_id='$atr_id'");
                            $cekit = mysqli_fetch_assoc($cek_items);
                            $cekitem = $cekit ? $cekit['harga'] : '';
                            $ceksatuan = $cekit ? $cekit['satuan'] : '';
                            ?>
                            <label class="form-check-label">
                                <input type="checkbox" <?= $cekitem ? 'checked' : '' ?> class="form-check-input is_harga" data-id="<?= $dta['id'] ?>"> <span>Aktifkan harga per item?</span>
                            </label>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5">No</th>
                                    <th>Item Atribut</th>
                                    <th width="350">Harga</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $items = mysqli_query($conn, "SELECT * FROM item_layanan WHERE atribut_id='$atr_id'");
                                $no = 1;
                                foreach ($items as $itm) { ?>
                                    <tr class="item-content">
                                        <td><?= $no ?></td>
                                        <td>
                                            <input type="text" name="item[]" class="form-control" style="height: 30px; font-size: 13px;" placeholder="Nama Item" value="<?= $itm['item_pilihan'] ?>">
                                        </td>
                                        <td>
                                            <div class="row">
                                                <span class="col-md-1">Rp</span>
                                                <div class="col-md-5 pr-0">
                                                    <input type="number" name="harga[]" class="form-control harga-vl<?= $dta['id'] ?>" style="height: 30px; font-size: 13px;" placeholder="Harga" value="<?= $itm['harga'] ? $itm['harga'] : '' ?>" <?= $itm['harga'] ? '' : 'readonly' ?> required>
                                                </div>
                                                <span class="col-md-1">/</span>
                                                <div class="col-md-5 pl-0">
                                                    <input type="text" name="satuan[]" class="form-control satuan_val satuan-vl<?= $dta['id'] ?>" data-id="<?= $dta['id'] ?>" style="height: 30px; font-size: 13px;" placeholder="Satuan (Optional)" value="<?= $itm['satuan'] ?>" <?= $itm['harga'] ? '' : 'readonly' ?>>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger del-item"><i class="fa fa-trash"></i> Hapus</button>
                                        </td>
                                    </tr>
                                    <?php $no=$no+1; 
                                } ?>
                                <tr class="item-content-add" style="background-color: #F4F8FB;">
                                    <td class="no-last no-lastid<?= $dta['id'] ?>" data-id="<?= $dta['id'] ?>"><?= $no ?></td>
                                    <td>
                                        <input type="text" class="form-control nama-item" style="height: 30px; font-size: 13px;" placeholder="Nama Item">
                                    </td>
                                    <td>
                                        <div class="row">
                                            <span class="col-md-1">Rp</span>
                                            <div class="col-md-5 pr-0">
                                                <input type="number" class="form-control harga-vl<?= $dta['id'] ?> input-last harga-item" style="height: 30px; font-size: 13px;" placeholder="Harga" <?= ($cekitem) ? '' : 'readonly' ?>>
                                            </div>
                                            <span class="col-md-1">/</span>
                                            <div class="col-md-5 pl-0">
                                                <input type="text" class="form-control satuan_val satuan-vl<?= $dta['id'] ?> satuan-item" data-id="<?= $dta['id'] ?>" style="height: 30px; font-size: 13px;" placeholder="Satuan (Optional)" value="<?= $ceksatuan ?>" <?= ($cekitem) ? '' : 'readonly' ?>>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success add-item" data-id="<?= $dta['id'] ?>"><i class="fa fa-plus"></i> Tambah</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success" name="set_item">Simpan</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit<?= $dta['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Atribut Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-edit" method="POST">
                        <div class="form-group row">
                            <label class="col-md-4">Nama Atribut</label>
                            <div class="col-md-8">
                                <input type="hidden" name="id" value="<?= $dta['id'] ?>">
                                <input type="text" name="nama_atribut" required="required" class="form-control" placeholder="Nama Atribut..." autocomplete="off" value="<?= $dta['nama_atribut'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Properti Inputan</label>
                            <div class="col-md-8">
                                <?php $opt_properti = ['required', 'optional']; ?>
                                <select class="form-control" name="properti" required="">
                                    <?php foreach ($opt_properti as $prp) { ?>
                                        <option value="<?= $prp ?>" <?php if ($prp == $dta['properti']) echo "selected" ?>><?= ucwords($prp) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Inputan Warna?</label>
                            <div class="col-md-8">
                                <input type="radio" name="input_warna" id="input_warna_e1<?= $dta['id'] ?>" required="required" value="1" <?= $dta['input_warna']==1 ? 'checked' : '' ?>> <label for="input_warna_e1<?= $dta['id'] ?>">Ya&nbsp;&nbsp;</label>
                                <input type="radio" name="input_warna" id="input_warna_2<?= $dta['id'] ?>" required="required" value="0" <?= $dta['input_warna']==0 ? 'checked' : '' ?>> <label for="input_warna_2<?= $dta['id'] ?>">Tidak</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Item Atribut</label>
                            <div class="col-md-8">
                                <input type="radio" class="item_atr_e1" name="item" id="item_atr_e1<?= $dta['id'] ?>" required="required" value="1" <?= $dta['item']==1 ? 'checked' : '' ?>> <label for="item_atr_e1<?= $dta['id'] ?>">Ya&nbsp;&nbsp;</label>
                                <input type="radio" class="item_atr_e2" name="item" id="item_atr_e2<?= $dta['id'] ?>" required="required" value="0" <?= $dta['item']==0 ? 'checked' : '' ?>> <label for="item_atr_e2<?= $dta['id'] ?>">Tidak</label>
                            </div>
                        </div>
                        <div class="form-group row biaya_add_e" <?= $dta['item']==1 ? 'hidden' : '' ?>>
                            <label class="col-md-4">Biaya Tambahan (Optional)</label>
                            <div class="col-md-8">
                                <input type="number" name="harga" class="form-control harga_add_e" placeholder="Isi jika ada biaya tambahan untuk atribut ini" autocomplete="off" value="<?= $dta['harga']!=0 ? $dta['harga'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Tambahan Waktu Kerja (Menit)</label>
                            <div class="col-md-8">
                                <input type="number" name="waktu_kerja" class="form-control" placeholder="Tambahan Waktu Kerja (Optional)" autocomplete="off" value="<?= $dta['waktu_kerja']!=0 ? $dta['waktu_kerja'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Status</label>
                            <div class="col-md-8">
                                <?php $status = ['active', 'nonactive']; ?>
                                <select class="form-control" name="status" required="">
                                    <?php foreach ($status as $sts) { ?>
                                        <option value="<?= $sts ?>" <?php if ($sts == $dta['status']) echo "selected" ?>><?= ucwords($sts) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <button type="submit" name="edit_atribut" class="btn btn-success">Simpan</button>
                                <button class="btn btn-primary" type="button" data-dismiss="modal" aria-hidden="true">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus<?= $dta['id'] ?>">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        Yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="?layanan_id=<?= $ly_id ?>&hapus_data=true&id=<?= $dta['id'] ?>" role="button" class="btn btn-danger" name="edit_data">Hapus</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


<script>
    $(document).ready(function() {
        $('#nv-layanan').addClass('mm-active');
        $('#sub-layanan').addClass('mm-show');
        $('#nv-layanan<?= $ly_id ?>').addClass('mm-active');

        $('#biaya_add').hide();
        $('.item_atr1').click(function(event) {
            $('#harga_add').val('');
            $('#biaya_add').hide();
        });
        $('.item_atr2').click(function(event) {
            $('#harga_add').val('');
            $('#biaya_add').show();
        });

        $('.item_atr_e1').click(function(event) {
            $(this).parents('.form-edit').find('.harga_add_e').val('');
            $(this).parents('.form-edit').find('.biaya_add_e').attr('hidden', '');
        });
        $('.item_atr_e2').click(function(event) {
            if (!confirm('Warning: Semua item atribut yang ada akan dihapus!')) {
                $(this).parents('.form-edit').find('.item_atr_e1').prop('checked', true);
                return;
            }
            $(this).parents('.form-edit').find('.harga_add_e').val('');
            $(this).parents('.form-edit').find('.biaya_add_e').removeAttr('hidden');
        });

        // SET ITEM
        $('.is_harga').change(function(event) {
            var id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                $('.harga-vl'+id).removeAttr('readonly').attr('required', '');
                $('.satuan-vl'+id).removeAttr('readonly');
                $('.input-last').removeAttr('required');
            } else {
                $('.harga-vl'+id).val('').attr('readonly', '').removeAttr('required');
                $('.satuan-vl'+id).val('').attr('readonly', '').removeAttr('required');
            }
        });

        $(document).on('keyup', '.satuan_val', function(event) {
            var id = $(this).attr('data-id');
            $('.satuan-vl'+id).val($(this).val());
        });

        $(document).on('click', '.del-item', function(event) {
            var no = $(this).parents('.item-content-big').find('.no-last').text();
            var id = $(this).parents('.item-content-big').find('.no-last').attr('data-id');
            $('.no-lastid'+id).text(no-1);
            $(this).parents('.item-content').remove();
        });

        $('.add-item').click(function(event) {
            var id = $(this).parents('.item-content-big').find('.no-last').attr('data-id');
            var no = $(this).parents('.item-content-big').find('.no-last').text();
            var nama = $(this).parents('.item-content-add').find('.nama-item');
            var harga = $(this).parents('.item-content-add').find('.harga-item');
            var satuan = $(this).parents('.item-content-add').find('.satuan-item');
            var is_harga = $(this).parents('.item-content-big').find('.is_harga')

            if (nama.val()=='') {
                alert('Lengkapi data!');
                return
            }

            var ronly = 'readonly';
            if (is_harga.is(':checked')) {
                ronly = '';
                if (harga.val()=='') {
                    alert('Lengkapi data!');
                    return
                }
            }

            $('.no-lastid'+id).text(parseInt(no)+1);
            $(this).parents('.item-content-add').before(`<tr class="item-content">
                <td>`+no+`</td>
                <td>
                <input type="text" name="item[]" class="form-control" style="height: 30px; font-size: 13px;" placeholder="Nama Item" value="`+nama.val()+`">
                </td>
                <td>
                <div class="row">
                <span class="col-md-1">Rp</span>
                <div class="col-md-5 pr-0">
                <input type="number" name="harga[]" class="form-control harga-vl`+id+`" style="height: 30px; font-size: 13px;" placeholder="Harga" value="`+harga.val()+`" required `+ronly+`>
                </div>
                <span class="col-md-1">/</span>
                <div class="col-md-5 pl-0">
                <input type="text" name="satuan[]" class="form-control satuan_val satuan-vl`+id+`" data-id="`+id+`" style="height: 30px; font-size: 13px;" placeholder="Satuan (Optional)" value="`+satuan.val()+`" `+ronly+`>
                </div>
                </div>
                </td>
                <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger del-item"><i class="fa fa-trash"></i> Hapus</button>
                </td>
                </tr>`);

            nama.val('');
            harga.val('');

        });


                <?php if ($success == true) { ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diproses',
                        text: 'Data telah telah diperbarui',
                        preConfirm: () => {
                            window.location.href='layanan.php?layanan_id=<?= $ly_id ?>';
                        }
                    });
                <?php } ?>
            });
        </script>