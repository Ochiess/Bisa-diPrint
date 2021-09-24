<?php
require '../function.php';
if (isset($_POST["daftar"])) {

    if (registrasi_agen($_POST) > 0) {
        echo "<script> 
        alert ('Berhasil mendaftar');
        document.location.href = 'login.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    };
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>diPrint- Pendaftaran</title>

    <!-- Custom fonts for this template-->
    <link href="../layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../layout/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img width="500" style="margin: 20px;" src="../assets/img/hero-img.png" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                            </div>
                            <form class="user" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="nama_percetakan" name="nama_percetakan" placeholder="Nama Percetakan">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nama_pemilik" name="nama_pemilik" placeholder="Nama Pemilik">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control form-control-user" id="telpon" name="telpon" placeholder="Nomor Telepon">
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Alamat Percetakan">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Alamat Email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="ulang_password" name="ulang_password" placeholder="Ulangi Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="keterangan" name="keterangan" placeholder="Keterangan Tambahan">
                                </div>
                                <div class="form-group">
                                    <small class="form-text text-muted ml-2">Upload Foto Percetakan</small>
                                    <div class="text-center ml-2">
                                        <div style="width: 100%; height: 7cm; border: dashed 2px grey; border-radius: 4px; margin: auto; overflow: hidden;">
                                            <img src="assets/images/placeholder.jpg" style="height: 100%; width: 100%;" id="thumb-poto">
                                        </div>
                                        <div style="margin-top: 5px; margin-bottom: 10px;">
                                            <label class="btn btn-sm btn-secondary" for="btn-poto"><i class="fa fa-upload"></i> Upload Foto</label>
                                            <input type="file" name="poto" id="btn-poto" style="display: none;" required="">
                                        </div>
                                    </div>
                                </div>
                                <button id="daftar" class="btn btn-primary btn-user btn-block" name="daftar" type="submit">
                                    Buat Akun
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Sudah Punya Akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../layout/vendor/jquery/jquery.min.js"></script>
    <script src="../layout/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../layout/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../layout/js/sb-admin-2.min.js"></script>
    <script>
        $('#btn-poto').change(function(e) {
            var foto_add = $(this).prop('files')[0];
            validasi_foto(foto_add, '#thumb-poto', '#btn-poto', 2048000, '2 MB')
        });

        function validasi_foto(foto, thumb, btn, size, ket) {
            var check = 0;

            var ext = ['image/jpeg', 'image/png', 'image/bmp'];

            $.each(ext, function(key, val) {
                if (foto.type == val) check = check + 1;
            });

            if (check == 1) {
                if (foto.size > size) {
                    alert('Ukuran file terlalu besar. File harus maksimal '+ket);
                    $(btn).val('');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    $(thumb).attr('src', e.target.result);
                }
                reader.readAsDataURL(foto);
            } else {
                alert('Format file tidak dibolehkan, pilih file lain');
                $(btn).val('');
                return;
            }
            return true;
        }
    </script>
</body>

</html>