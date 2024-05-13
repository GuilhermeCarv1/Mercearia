<?php
session_start();
include("conexao.php");

$idProduto = $_POST['id'];
$Name = validarDados($conexao, $_POST['name']);
$Quantidade = validarDados($conexao, $_POST['quantidade']);
$Preco = validarDados($conexao, $_POST['preco']);
$Imagem = validarDados($conexao, $_POST['imagem']);

function validarDados($conexao, $dados) {
    $dados = trim($dados);
    $dados = mysqli_real_escape_string($conexao, $dados);

    return $dados;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = validarDados($conexao, $_POST['name']);
    $Quantidade = validarDados($conexao, $_POST['quantidade']);
    $Preco = validarDados($conexao, $_POST['preco']);
    $Imagem = validarDados($conexao, $_POST['imagem']);

    if (empty($Name) || empty($Preco) || empty($Imagem)) {
        $_SESSION['success_messag_ADM'] = "Por favor, preencha todos os campos.";
        header('Location: ADM.php');
        exit();
    }

    $query = "UPDATE produto SET Nome = '$Name', Quantidade = '$Quantidade', Preco = '$Preco', Img = '$Imagem' WHERE id = $idProduto";

    if (mysqli_query($conexao, $query)) {
        $_SESSION['success_messag_ADM'] = "Dados atualizados com sucesso!";
    } else {
        $_SESSION['success_messag_ADM'] = "Erro ao atualizar os dados: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
    header('Location: ADM.php');
    exit();
}
?>
