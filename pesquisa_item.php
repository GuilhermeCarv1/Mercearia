<?php
include('conexao.php');

if (isset($_GET["id"])) {
    $produtoId = $_GET["id"];


    $query = "SELECT * FROM produto WHERE id = $produtoId";
    $result = mysqli_query($conexao, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo '<input type="hidden" name="id" value=' . $row["id"] . ' id="id">';
        echo '<label for="username">Produto:</label>';
        echo '<input type="text" name="name" id="name" value=' . $row["Nome"] . ' required><br> ';
        echo '<label for="username">Quantidade:</label>';
        echo '<input type="text" name="quantidade" id="quantidade" value=' . $row["Quantidade"] . ' required><br>';
        echo '<label for="username">Preço:</label>';
        echo '<input type="float" name="preco" id="preco" value=' . $row["Preco"] . ' required><br>';
        echo '<label for="username">Imagem:</label>';
        echo '<input type="text" name="imagem" id="imagem" value=' . $row["Img"] . ' required><br>';
        echo '<button class="ButtonMaster" type="submit">Editar</button>';

    } else {
        echo "Produto não encontrado.";
    }


    mysqli_close($conexao);
} else {
    echo "ID do produto não especificado na solicitação.";
}
?>