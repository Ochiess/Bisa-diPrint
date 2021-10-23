<?php
session_start();
require '../function.php';
// cek cookie
if( isset($_COOKIE['key_admin']) && isset($_COOKIE['oci_admin']) ) {

   $key_admin = $_COOKIE['key_admin'];
   $oci_admin = $_COOKIE['oci_admin']; 

   // ambil username berdasarkan id
   $result = mysqli_query($conn, "SELECT username FROM super_admin WHERE id = $key_admin");
   $row = mysqli_fetch_assoc($result);

   //cek cookie dan username
    if( $oci_admin === hash('sha256', $row['username']) ) {
        $_SESSION['masuk_admin'] = true;
        $_SESSION['key_admin'] = $key_admin;
    }
}
if( isset($_SESSION["masuk_admin"]) ) {
    header("Location: index.php");
    exit;
  }


if(isset($_POST["login"]) ) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM super_admin WHERE username = '$username'");

    // cek username
    if(mysqli_num_rows($result)===1 ) {
        // cek password
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row["password"]) ) {

            // set session
            $_SESSION["masuk_admin"] = true;
            $_SESSION['key_admin'] = $row['id'];
            
            // cek remember me
            if( isset($_POST['remember']) ) {
                //buat cookienya
                setcookie('key_admin', $row['id'],strtotime('+7 days'),'/' );
                setcookie('oci_admin', hash('sha256',$row['username']), strtotime('+7 days'),'/');
            }
            header("Location: index.php");
            exit;
        }
    }

    $error = true;
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

    <title>diPrint - Login Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../layout/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../layout/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img width="500" style="margin: 20px;" src="../assets/img/hero-img.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                        <?php if(isset($error) ) : ?>
                                            <p style="color:red; font-style: italic;">Username / Password Anda Salah</p>
                                        <?php endif; ?>
                                    </div>
                                    <form action="" class="user" id="form-login" method="POST">
                                        <div class="form-group">
                                            <input for="username" type="username" name="username" id="username" class="form-control form-control-user" id="username" aria-describedby="usernameHelp" placeholder="Alamat Username...">
                                        </div>
                                        <div class="form-group">
                                            <input for="password" type="password" name="password" id="password" class="form-control form-control-user" id="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                                <label for="remember" class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
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
</body>

</html>