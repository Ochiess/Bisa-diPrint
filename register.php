<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bisa diPrint- Daftar user</title>

    <!-- Custom fonts for this template-->
    <link href="layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="layout/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img width="500" style="margin: 20px;" src="assets/img/hero-img.png" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Sebuah Akun!</h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nama_lengkap"
                                            placeholder="Nama Lengkap">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="nama_akun"
                                            placeholder="Nama Akun">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="hp"
                                        placeholder="Nomor Telepon/WA">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email"
                                        placeholder="Alamat Email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password"
                                            placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="ulang_password" placeholder="Ulangi Password">
                                    </div>
                                </div>
                                <a href="" id="daftar" class="btn btn-primary btn-user btn-block">
                                    Buat Akun
                                </a>
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
    <script src="layout/vendor/jquery/jquery.min.js"></script>
    <script src="layout/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="layout/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="layout/js/sb-admin-2.min.js"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.2.7/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/8.2.7/firebase-analytics.js"></script>

    <script>
        $(document).ready(function () {
            $('#daftar').click(function (e) {
                e.preventDefault();

                var nama_depan = $('#nama_depan').val();
                var nama_belakang = $('#nama_belakang').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var ulang_password = $('#ulang_password').val();

                if (password != ulang_password) {
                    alert('Password tidak sesuai');
                } else {
                }
            });
        });
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var firebaseConfig = {
            apiKey: "AIzaSyBDre3emReDz3lngHmgxbhR2o8Cr4C2ZaY",
            authDomain: "bisadiprint.firebaseapp.com",
            databaseURL: "https://bisadiprint-default-rtdb.firebaseio.com",
            projectId: "bisadiprint",
            storageBucket: "bisadiprint.appspot.com",
            messagingSenderId: "553465540154",
            appId: "1:553465540154:web:fef4ba99d30500d70b4f03",
            measurementId: "G-XDY51XLPJ1"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();
        var database = firebase.database();
        var userId = firebase.auth().currentUser.uid;
        database.ref('users/' + userId).set({
            username: name,
            email: email,
            profile_picture: imageUrl
        });


    </script>

</body>

</html>