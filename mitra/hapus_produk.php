<?php
require '../function.php';

$id=$_GET["id"];

if (hapus_produk($id) > 0 ) {
    echo "<script> 
        alert ('Data terhapus');
        document.location.href = 'pengaturan.php';
         </script>";
    }
    else {
    echo "<script> 
        alert ('Data Gagal dihapus');
        document.location.href = 'pengaturan.php';
         </script>";
    }

?>
