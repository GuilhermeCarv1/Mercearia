<?php 
session_start();
include('verifica_is_adm.php');

$ArrayJSON = $_POST['meuArrayInput'];
$PrecoTotal = $_POST['Preco_total'];

$array = json_decode($ArrayJSON, true);
$ArrayJSONEdit = json_encode($ArrayJSON);


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mercearia</title>
    <link rel="stylesheet" href="./master.css">
    <link rel="stylesheet" href="./css/ECOMENDA.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"crossorigin="anonymous">

</head>
<body>
    <nav>
        <ul class="NavBarTop">
            <li><a href="LOGIN.php">LOGIN</a></li>
            <li><a href="HOME.php">HOME</a></li>
            <?php
                if(isset($_SESSION['modo_adm'])):
            ?>
            <li><a href="ADM.php">ADM</a></li>
            <li><a href="logout.php">SAIR</a></li>
            <?php
                endif;
                unset($_SESSION['modo_adm']);
            ?>
            <li><a href="HOME.php">Cancelar</a></li>

        </ul>
    </nav>
    <div>
    <form class="container campEcomendas" action="Concluir-Compra.php" method="post" onsubmit="return validarFormulario();">
        <div>
            <h3>Produtos</h3>

            <?php 
            if ($array !== null) {
                foreach ($array as $item) {      
            ?>
                <label>produto: <?php echo $item[3]?></label>
                <label>, Quantidade: <?php echo $item[1]?></label>
                <label>, Preço: <?php echo $item[2]?></label><br>
            <?php 
                }
            } else {
                echo "Erro na decodificação do JSON.";
            }
            ?>
            <br><h6>Preço Total: <?php echo $PrecoTotal ?></h6>
            <hr>

        </div><hr>
        <h3>Formulario</h3>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        
        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br>
        
        <label for="endereco">Endereço:</label>
        <input type="text" id="morada" name="morada" required><br>

        <input type="hidden" id="produtos" name="produtos" value='<?php echo $ArrayJSON ?>' required><br>

        <input type="hidden" name="Preco_total" id="Preco_total" value="<?php echo $PrecoTotal; ?>">

        <button type="submit">COMPRAR</button>
    </form>

    </div>
    <script>
        function validarFormulario() {
            var nome = document.getElementById("nome").value;
            var dataNascimento = document.getElementById("data_nascimento").value;
            var morada = document.getElementById("morada").value;

            if (nome === "" || dataNascimento === "" || morada === "") {
                alert("Nenhum dos campos pode ficar vazio.");
                return false;
            }

            var dataNascimentoDate = new Date(dataNascimento);
            var hoje = new Date();
            var idade = hoje.getFullYear() - dataNascimentoDate.getFullYear();

            if (hoje.getMonth() < dataNascimentoDate.getMonth() || (hoje.getMonth() === dataNascimentoDate.getMonth() && hoje.getDate() < dataNascimentoDate.getDate())) {
                idade--;
            }

            if (idade < 18) {
                alert("Você deve ter pelo menos 18 anos para se cadastrar.");
                return false;
            }

            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"crossorigin="anonymous"></script>
</body>
</html>