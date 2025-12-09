<?php
session_start();
session_unset();
session_destroy();
setcookie("remember_id", "", time() - 3600, "/");
header("Location: login.php?logged_out=1");
exit;
?>
