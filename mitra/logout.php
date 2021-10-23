<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id_mitra', NULL, -3600, '/');
setcookie('oci_m', NULL, -3600, '/');

header("Location: ../index.php");
exit;

?>