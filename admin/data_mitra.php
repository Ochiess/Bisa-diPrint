<?php
require('template/header.php');
?>
<!--main content-->

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div>Daftar Pengguna</div>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table class="mb-0 table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Photo</th>
                                        <th>Nama Percetakan</th>
                                        <th>Nama Pemilik</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>@mdo</td>
                                        <td>dhgsdffs</td>
                                        <td>dhgsdffs</td>
                                        <td>dhgsdffs</td>
                                        <td>
                                        <button class="mb-2 mr-2 btn btn-primary"><i class="fa fa-key"></i> Reset Password</button>
                                        <button class="mb-2 mr-2 btn btn-danger"><i class="fa fa-times-circle"></i> Banned</button>
                                        </td> <!--tidak responsive ki bagian ini gan-->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</div>

<?php
require('template/footer.php');
?>