<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('key_admin', NULL, -3600, '/');
setcookie('oci_admin', NULL, -3600, '/');

header("Location: ../index.php");
exit;

?>