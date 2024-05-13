<?php
session_start();
unset($_SESSION['modo_adm']);
unset($_SESSION['modo_admTwo']);
session_destroy();
header('Location: HOME.php');
exit();
?>