<?php
require_once 'conexao.php';

if (!$_SESSION['usuario']){

    header('Location: LOGIN.php');
}else
?>