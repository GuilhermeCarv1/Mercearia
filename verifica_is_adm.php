<?php
require_once 'conexao.php';

if (isset($_SESSION['usuario'])) {
    $_SESSION['modo_adm'] = true;
    $_SESSION['modo_admTwo'] = true;


}
?>
