<?php
session_start();
include("conexao.php");

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

    if (empty($Name) || empty($Quantidade) || empty($Preco) || empty($Imagem)) {
        $_SESSION['success_messag_ADM'] = "Por favor, preencha todos os campos.";
        header('Location: ADM.php');
        exit();
    }
    $query = "INSERT INTO produto (Nome, Quantidade, Preco, Img) 
            VALUES ('$Name', '$Quantidade','$Preco','$Imagem')";

    if (mysqli_query($conexao, $query)) {
        $_SESSION['success_messag_ADM'] = "Dados inseridos com sucesso! Os orçamentos podem ser visualizados no usuário.";
    } else {
        $_SESSION['success_messag_ADM'] = "Erro ao inserir dados: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
    header('Location: ADM.php');
    exit();
}
?>