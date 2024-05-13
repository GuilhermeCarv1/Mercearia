<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $IdProduto = $_POST['id'];

        $query = "DELETE FROM produto WHERE id = $IdProduto";
        $result = mysqli_query($conexao, $query);

        header('Location: HOME.php');

    }
}
?>