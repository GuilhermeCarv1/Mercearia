<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $encomenda = $_POST['id'];

        // Excluir linhas associadas na tabela produtos_encomendas
        $query_delete_produtos = "DELETE FROM produtos_encomendas WHERE encomenda_id = $encomenda";
        $result_delete_produtos = mysqli_query($conexao, $query_delete_produtos);

        // Excluir a linha na tabela encomendas se não houver erro ao excluir na tabela produtos_encomendas
        if ($result_delete_produtos) {
            $query_delete_encomenda = "DELETE FROM encomendas WHERE id = $encomenda";
            $result_delete_encomenda = mysqli_query($conexao, $query_delete_encomenda);

            if ($result_delete_encomenda) {
                header('Location: ADM.php');
            } else {
                echo "Erro ao excluir encomenda.";
            }
        } else {
            echo "Erro ao excluir produtos associados à encomenda.";
        }
    }
}
?>
