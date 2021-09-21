<?php
require('template/header.php');
?>

<div class="app-main__outer">
    <div class="">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Daftar Antrian</h5>
                <table class="mb-0 table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Id user</th>
                            <th>Nama user</th>
                            <th>Jenis Kertas</th>
                            <th>Jumlah Rangkap</th>
                            <th>Warna</th>
                            <th>Halaman</th>
                            <th>Jumlah Halaman</th>
                            <th>Waktu Pengambilan</th>
                            <th>Catatan</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>
                                <button type="button" class="mb-2 mr-2 btn btn-primary active">Primary
                                </button>
                                <!-- paska nnnti klik button langsung masuk ke daftar tunggu, nnti di daftar tunggu kalo slsai mi org na ambil barangnya bary klik buttonnya turs masuk otomatis ke history-->
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--footer-->
    <?php
    require('template/footer.php');
    ?>