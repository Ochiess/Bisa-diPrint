<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('key', NULL, -3600, '/');
setcookie('oci', NULL, -3600, '/');

header("Location: ../index.php");
exit;

?>