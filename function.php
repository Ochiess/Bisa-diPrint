<?php
require 'koneksi.php';

    function registrasi_user($data) {

        global $conn;

        $nama_lengkap = $data["nama_lengkap"];
        $nama_akun = strtolower(stripslashes($data["nama_akun"]));
        $hp = $data["hp"];
        $email = $data["email"];
        $password = $data["password"];
        $ulang_password = $data["ulang_password"];
        
        // cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");

        if(mysqli_fetch_assoc($result)) {
            echo "<script>
                    alert('email sudah terdaftar!')
                </script>";
                return false;
        }

        //cek kesesuaian password
        if($password !== $ulang_password) {
            echo "<script>
                alert('Password Tidak Sama');
            </script>";

            return false;
        }

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user VALUES(NULL, '', '$nama_lengkap', '$nama_akun', '$hp', '$email', '$password')";

        // menambahkan user baru kedatabase
        $res = mysqli_query($conn, $sql);

        if ($res) {

            return true;    
        } else {

            return false;
        }
    }

    //untuk agen percetakan
    function registrasi_agen($data) {
        global $conn;
        
        $nama_percetakan = $data["nama_percetakan"];
        $nama_pemilik = $data["nama_pemilik"];
        $telpon = $data["telpon"];
        $email = $data["email"];
        $alamat = $data["alamat"];
        $password = $data["password"];
        $ulang_password = $data["ulang_password"];
        $keterangan = $data["keterangan"];

        // upload gambar
        $poto = upload();
        if (!$poto) {
            return false;
        }

        
        // cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT email FROM agen WHERE email = '$email'");

        if(mysqli_fetch_assoc($result)) {
            echo "<script>
                    alert('email sudah terdaftar!')
                </script>";
                return false;
        }

        //cek kesesuaian password
        if($password !== $ulang_password) {
            echo "<script>
                alert('Password Tidak Sama');
            </script>";

            return false;
        }

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
        // menambahkan user baru kedatabase
        mysqli_query($conn, "INSERT INTO agen VALUES(NULL, '$nama_percetakan', '$nama_pemilik', '$telpon', '$email', '$alamat', '$password', '$poto', '$keterangan', 'new')");

        // add attribut layanan & config
        $agen_id = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO warna_tulisan VALUES(NULL, '$agen_id', '100', '200')");

        $jenis_kertas = ["Letter", "A4", "F4 (Folio)", "A3", "B5", "A5"];
        foreach ($jenis_kertas as $jnk) {
            mysqli_query($conn, "INSERT INTO jenis_kertas VALUES(NULL, '$agen_id', '$jnk', '0')");
        }

        $ukuran_foto = ["Ukuran 2x3", "Ukuran 3x4", "Ukuran 4x6"];
        foreach ($ukuran_foto as $ukf) {
            mysqli_query($conn, "INSERT INTO ukuran_foto VALUES(NULL, '$agen_id', '$ukf', '0')");
        }
        
        mysqli_query($conn, "INSERT INTO setting_agen VALUES(NULL, '$agen_id', '1', '1', NULL, NULL, '1', '1', '0', '0')");

        return 1;
    }

    //function upload
    function upload() {
        $namaFile = $_FILES['poto']['name'];
        $ukuranFile = $_FILES['poto']['size'];
        $error = $_FILES['poto']['error'];
        $tmpName = $_FILES['poto']['tmp_name'];

        // cek apakah tidak ada gambar yang diupload
        if($error === 4 ) {
            echo "<script> 
            alert('Mohon untuk memilih Foto terlebih dahulu ');
            </script>";
            return false;
        }

        //cek apakah yang diupload adalah ganbar
        $esktensiGambarValid = ['jpg', 'jpeg', 'png'];
        $esktensiGambar = explode('.',$namaFile);
        $esktensiGambar = strtolower(end($esktensiGambar));
        if( !in_array($esktensiGambar, $esktensiGambarValid) ) {
            echo "<script> 
            alert('Mohon diperiksa kembali, mungkin file yang anda upload bukan foto');
            </script>";
            return false;
        }

        //cek ukuran file terlalu besar
        if($ukuranFile > 100000000) {
            echo "<script> 
            alert('Ukuran file terlalu besar ');
            </script>";
            return false; 
        }

        //generate nama baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $esktensiGambar;

        //kalo lulus pengecekan, gambar siap di upload
        move_uploaded_file($tmpName, 'img/daftar' . $namaFileBaru);

        return $namaFileBaru;
    }

    function marchent() {

        global $conn;
        
        // cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM agen WHERE status='active'");

        return $result;
    }

   function tambah_produk($data) {

    global $conn;
    
    $id_admin = $data["id"];
    $jenis = $data["jenis"];
    $harga = $data["harga"];

    $query = "INSERT INTO produk VALUES(NULL,'$id_admin','$harga','$jenis')";

    mysqli_query($conn, $query);

    return true;

   }

   
   function baca_produk($id) {

    global $conn;
    
    // cek username sudah ada atau belum
    $q = "SELECT * FROM produk WHERE id_admin = '$id'";

    return query($q);
}

   function query($query) {

    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {

        $rows[] = $row;
    }
    return $rows;
   }

   function ubah_produk($data) {

    global $conn;
    $id=$data["id"];
   // $id_admin=$data["id_admin"];
    $jenis = $data["jenis"];
    $harga = $data["harga"];

    $query = "UPDATE produk SET  jenis='$jenis', harga='$harga' WHERE id=$id";

    mysqli_query($conn, $query);

    return true;
   }

   function hapus_produk($id) {
       global $conn;
       mysqli_query($conn, "DELETE FROM produk WHERE id=$id");
       return mysqli_affected_rows($conn);
   }

   //untuk menampilkan jualannya admin
   function panggil_produk($id) {
   
        global $conn;
        // cek username sudah ada atau belum
        $result = mysqli_query($conn, "SELECT * FROM produk WHERE id_admin='$id'");

        return $result;
   }

   //tampil profil user
   function tampil_profil($id) {

       global $conn;

       $tampil = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");

       return mysqli_fetch_assoc($tampil);

   }

 // untuk user
   function update_profil($data) {

    global $conn;

    $id=$data["id"];
    $nama_lengkap=$data["nama_lengkap"];
    $nama_akun=$data["nama_akun"];
    $hp=$data["hp"];
    $email=$data["email"];

    //kalo ada foto
    $photo = photo();
        if (!$photo) {
            return false;
        }

    $query = "UPDATE user SET photo='$photo', nama_lengkap='$nama_lengkap', nama_akun='$nama_akun', hp='$hp', email='$email' WHERE id=$id";
     
    mysqli_query($conn,$query);

    return true;
   }


   // function untuk upload photo user
   function photo() {
       $namaFile = $_FILES['photo']['name'];
       $ukuranFile = $_FILES['photo']['size'];
       $tmpName = $_FILES['photo']['tmp_name'];

       //menentukan ekstensi gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.',$namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar)); 
        if(!in_array($ekstensiGambar, $ekstensiGambarValid) ) {
            echo "<script>
            alert('Yakin Tidak Mengganti Photo Profil?');
           </script>";

           return false;
        }

        if($ukuranFile > 100000000) {
            echo "<script>
                alert('Ukuran Photo Terlalu Besar');
            </script>";
            return false;
        }

       //membuat nama file baru
       $namaFileBaru = uniqid();
       $namaFileBaru .= '.';
       $namaFileBaru .= $ekstensiGambar;

       move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

       return $namaFileBaru;
   }

   // function tampil profil untuk admin
   function lihat_profil($id) {

       global $conn;

       $lihat = mysqli_query($conn,"SELECT * FROM agen WHERE id = '$id'");

       return mysqli_fetch_assoc($lihat);
   }

   //function edit profile untuk admin
   function ubah_profil($data) {

       global $conn;

       $id = $data["id"];
       $nama_percetakan = $data["nama_percetakan"];
       $nama_pemilik = $data["nama_pemilik"];
       $telpon = $data["telpon"];
       $email = $data["email"];
       $alamat = $data["alamat"];
       
       $poto = upload();
        if (!$poto) {
            return false;
        }

       $query = "UPDATE agen SET nama_percetakan='$nama_percetakan', nama_pemilik='$nama_pemilik', telpon='$telpon', email='$email', alamat='$alamat', poto='$poto' WHERE id=$id";

       mysqli_query($conn, $query);

       return true;  

   }

   function cetak($data) {

    global $conn;

    $id_user = $data["id-user"];
    $id_agen = $data["id_agen"];
    $jenis_kertas = $data["jenis_kertas"];
    $jumlah_rangkap = $data["jumlah_rangkap"];
    $warna = $data["warna"];
    $jumlah_halaman = $data["jumlah_halaman"];
    $waktu_pengambilan = $data["waktu_pengambilan"];
    $catatan = $data["catatan"];
    $berkas = $data["berkas"];
    $harga = $data["harga"];

     // upload berkas
     $berkas = berkas();
     if (!$berkas) {
         return false;
     }

    $query = "INSERT INTO cetak VALUES(NULL,'$id_user', '$id_agen', '$jenis_kertas', '$jumlah_rangkap', '$warna', '$jumlah_halaman', '$waktu_pengambilan', '$catatan', '$berkas', '$harga')";

    mysqli_query($conn, $query);

    return true;

   }

   function berkas() {
       $namaFile = $_FILES['berkas']['name'];
       $ukuranFile = $_FILES['berkas']['size'];
       $error = $_FILES['berkas']['error'];
       $tmpName = $_FILES['berkas']['tmp_name'];

       //cek apakah sudahmi upload berkas atau belum
       if($error === 4) {
           echo "<script>
           alert('Berkas belum di upload');
           </script>";
           return false;
       }

       //menentukan ekstensi file
       $ekstensiFileValid = ['docx', 'pdf', 'doc', 'xls', 'xlsx'];
       $ekstensiFile = explode('.',$namaFile);
       $ekstensiFile = strtolower(end($ekstensiFile));
       if(!in_array($ekstensiFile, $ekstensiFileValid) ) {
           echo "<script>
           alert('Mohon upload berkas anda');
           </script>";

           return false;
       }

       //membuat ruang untuk file baru
       $namaFileBaru = uniqid();
       $namaFileBaru .= '.';
       $namaFileBaru .= $ekstensiFile;

       move_uploaded_file($tmpName, 'file/' . $namaFileBaru);

       return $namaFileBaru;
   }


?>