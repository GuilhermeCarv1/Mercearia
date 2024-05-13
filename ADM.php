<?php
session_start();
include('conexao.php');
include('verifica_login.php');

if (isset($_SESSION['usuario'])) {
} else {
    echo "Nenhum usuário logado.";
}
$query = "SELECT * FROM produto";
$result = mysqli_query($conexao, $query);
$qry = "SELECT * FROM encomendas";
$resul = mysqli_query($conexao, $qry);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mercearia</title>
    <link rel="stylesheet" href="./master.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"crossorigin="anonymous">

    <link rel="stylesheet" href="./css/ADM.css">
    <style>
        .btnClose{
            background-color: blue;
            color: aliceblue;
            border-radius: 5px;
            width: 35px;
        }
    </style>

</head>
<body>
    <nav>
        <ul class="NavBarTop">
            <li><a href="LOGIN.php">LOGIN</a></li>
            <li><a href="HOME.php">HOME</a></li>
            <li><a href="ADM.php">ADM</a></li>
            <li><a href="logout.php">SAIR</a></li>
            
        </ul>
    </nav>
    <br><br><br><br>
    <div class="row justify-content-center">
            <div class="col col-lg-8 ">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Produtos</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Encomendas</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    
                    <table class="table table-striped">
                    <tr class="table-light">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['Nome']; ?></td>
                            <td><?php echo $row['Quantidade']; ?></td>
                            <td><?php echo number_format($row['Preco'], 2, '.', ',');?></td>
                        </tr>
                    <?php
                        }
                        } else {
                            echo "<p>Não tem produtos.</p>";
                        }
                    ?>
                    </table>
                
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Id-Encomenda</th>
                            <th>Nome</th>
                            <th>Morada</th>
                            <th>Preço</th>
                            <th>Produtos</th>

                        </tr>
                        <?php
                        if (mysqli_num_rows($resul) > 0) {
                            while ($roW = mysqli_fetch_assoc($resul)) {
                                $idCopara = $roW['id'];
                        ?>
                        <tr>
                            <td><?php echo $roW['id']; ?></td>
                            <td><?php echo $roW['nome']; ?></td>
                            <td><?php echo $roW['morada']; ?></td>
                            <td><?php echo number_format($roW['preco_total'], 2, '.', ',');?></td>
                            <td>
                                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?php echo $roW['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $roW['id']; ?>">
                                    Lista-<?php echo $roW['id']; 
                                    $valor = $roW['id'];
                                    ?>
                                </a>
                            </td>
                            
                        </tr>
                        <div class="collapse" id="collapseExample<?php echo $roW['id']; ?>">
                            <?php echo $valor; ?>

                            <div class="card card-body">
                                <a class="btn btnClose" data-bs-toggle="collapse" href="#collapseExample<?php echo $roW['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $roW['id']; ?>">x</a>
                            <h4><?php echo $roW['nome']; ?></h4>
                            <ol>
                                
                            <?php
                                $qery = "SELECT * FROM produtos_encomendas WHERE encomenda_id = $valor";
                                $resu = mysqli_query($conexao, $qery);
                                if (mysqli_num_rows($resu) > 0) {
                                    while ($rw = mysqli_fetch_assoc($resu)) {
                                        $requi = "SELECT * FROM produto WHERE id = " . $rw['produto_id'];
                                        $pesqui = mysqli_query($conexao, $requi);
                                        
                                        if ($pesqui && mysqli_num_rows($pesqui) > 0) {
                                            $produto = mysqli_fetch_assoc($pesqui);
                                            $nomeProduto = $produto['Nome'];
                                            $precoProduto = $produto['Preco'];

                                        } else {
                                            $nomeProduto = "Produto não encontrado";
                                        }
                                ?>
                                        <li>Produto: <?php echo $nomeProduto; ?>, Quantidade: <?php echo $rw['quantidade']; ?>, Preço:<?php echo $precoProduto; ?>€</li>
                                        
                                <?php
                                    }
                                } else {
                                    echo "<p>Não tem produtos.</p>";
                                }
                                ?><br>
                                <form class="btnExcluirPrd" action="excluir_ecomenda.php" method="post">
                                    <input type="hidden" name="id" id="id" value=" <?php echo $roW['id'] ?>" required>
                                    <button type="submit" class="buttoExcluirProduto">EXCLUIR ENCOMENDA</button>
                                </form>
                            </ol>
                        </div>

                        </div>
                       

                    <?php
                        }
                        } else {
                            echo "<p>Não tem produtos.</p>";
                        }
                    ?>
                    </table>
                    </div>

                <div>
            </div>
        <div>
            
    <div class="container campBase">
        <div class="container">
            <div class= "col CampoModifiq">
                <form action="adicionar_produto.php" method="post">
                    <h4 for="username">Adicionar Produto</h4>
                    <label for="username">Nome do produto</label><br>
                    <input type="text" name="name" id="name" required><br>
                    <label for="username">Quantidade</label><br>
                    <input type="text" name="quantidade" id="quantidade" required><br>
                    <label for="username">Preço</label><br>
                    <input type="float" name="preco" id="preco" required><br>
                    <label for="username">Imagem</label><br>
                    <input type="text" name="imagem" id="imagem" required><br>
                    <button class="ButtonMaster" type="submit">Adicionar</button>
                </form>
            </div>
            <div class= "col CampoModifiq" >
                <form>
                    <h4>Editar Produto</h4>
                    <label for="Id">ID Do produto</label><br>
                    <input type="text" name="Id" id="Id" required><br>
                    <button type="button" class="ButtonMaster" onclick="pesquisarProduto()">Pesquisar</button>
                    
                    
                </form>
                <form action="editar_produto.php" method="post">
                    <div id="resultadoPesquisa">
                    </div>
                </form>

            </div>
        </div><br><br>
        
    </div>
    
    <script>
        function pesquisarProduto() {
            var produtoId = document.getElementById("Id").value;
            var resultadoPesquisa = document.getElementById("resultadoPesquisa");
            
            var xhr = new XMLHttpRequest();
            
            xhr.open("GET", "pesquisa_item.php?id=" + produtoId, true);
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    resultadoPesquisa.innerHTML = xhr.responseText;
                }
            };
            
            xhr.send();
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"crossorigin="anonymous"></script>
</body>
</html>