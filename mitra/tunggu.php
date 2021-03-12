<?php
require('template/header.php');
?>
<div class="app-main__outer">
    <div class="">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Daftar Pesanan</h5>
                <table class="mb-0 table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama user</th>
                            <th>Tanggal</th>
                            <th>Waktu Pengambilan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark suckeberg</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>
                                <button class="mb-2 mr-2 btn btn-success active">Success
                                </button>
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

    <?php
    require('template/footer.php');
    ?>