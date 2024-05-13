<?php
include 'conexao.php';

$nome = $_POST['nome'];
$dataNascimento = $_POST['data_nascimento'];
$morada = $_POST['morada'];
$produtos_encoded = $_POST['produtos'];
$precoTotal = $_POST['Preco_total'];


$produtos_decoded = html_entity_decode($produtos_encoded);
$produtosJson = json_decode($produtos_decoded, true);


$sql = "INSERT INTO encomendas (nome, data_nascimento, morada, preco_total) VALUES ('$nome', '$dataNascimento', '$morada', '$precoTotal')";

if ($conexao->query($sql) === TRUE) {
    $encomendaId = $conexao->insert_id;
    echo $encomendaId;

    if ($produtosJson !== null) {
        foreach ($produtosJson as $item) {
            
            $produtoId = $item[0];
            $quantidade = $item[1];

            $sql = "INSERT INTO produtos_encomendas (encomenda_id, produto_id, quantidade) VALUES ('$encomendaId', '$produtoId', '$quantidade')";
            
            $querY = "SELECT * FROM produto WHERE id = $produtoId";
            $resulT = mysqli_query($conexao, $querY);
 
            $row = mysqli_fetch_assoc($resulT);
            $quantidadeNoBanco = $row['Quantidade'];

            $QuantidadeSomada = $quantidadeNoBanco - $quantidade;

            $query = "UPDATE produto SET Quantidade = '$QuantidadeSomada' WHERE id = $produtoId";
            mysqli_query($conexao, $query);
            $conexao->query($sql);
        }
    }
    
    $mensagem = "Encomenda registrada com sucesso!";
} else {
    $mensagem = "Erro ao registrar a encomenda. ". $conexao->error;
}
header("Location: HOME.php?mensagem=" . urlencode($mensagem));
exit;
$conexao->close();
?>