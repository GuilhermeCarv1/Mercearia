<?php
session_start();
include('verifica_is_adm.php');
$query = "SELECT * FROM produto";
$result = mysqli_query($conexao, $query);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercearia</title>
    <link rel="stylesheet" href="./master.css">
    <link rel="stylesheet" href="./css/HOME.css">

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
            <button type="submit" class="ButtonCartStory" onClick="AbrirDivInfo()"><img src="./Icons/icons8-shopping-cart-30.png" alt="produtos"><label id="CartNumber"></label></button>
        </ul>
    </nav>
   <div class = "container" style = "max-height: 600px">
    <div id="carouselExampleFade" class="carousel slide carousel-fade">
        <div class="carousel-inner">
            <div class="carousel-item active" style = "max-height: 600px" >
            <img src="./Img/peoplehealthy.avif" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item"style = "max-height: 600px">
            <img src="./Img/peoplehealthy1.avif" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item"style = "max-height: 600px">
            <img src="./Img/peoplehealthy2.jpg" class="d-block w-100" alt="...">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" style="opacity: 0;" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" style="opacity: 0;" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
  <div class="CartCamp">
        <div id="CartProdutos"></div><br>
        <button class="ButtonCloseCart" onClick="FecharDivInfo()">X</button>
        <form class="campEcomendas" id="campEcomendas" action="adicionar_ecomenda.php" method="post">
            <input type="hidden" name="Preco_total" id="Preco_total" value="">
            <input type="hidden" name="meuArrayInput" id="meuArrayInput" value=''>
            <button type="button" class="buttoAdicionareEcomenda" onClick="ConcluirCart()">Confirmar</button>
            <button type="button" class="buttoAdicionareEcomenda" onClick="EscluirCart()">Excluir Carrinho</button>
        </form>
        </div>
    <header class="container CampoCards">
        <section class="row" id="produtos">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col col-md-4 col-sm-6 ">
                <div class="card" style="background-color: transparent;">
                    <?php
                        $mostrarDiv = isset($_SESSION['modo_admTwo']);

                        if ($mostrarDiv == 1) {
                            echo '<form class="btnExcluirPrd" action="excluir_produto.php" method="post">
                                <input type="hidden" name="id" id="id" value="' . $row['id'] . '" required>
                                <button type="submit" class="buttoExcluirProduto">X</button>
                            </form>';
                        }
                    ?>
                    <div style=
                    "
                    border-radius: 30px 30px 0 0;
                    background-image: url('<?php echo $row['Img']; ?>')
                    "
                    class="card-img-top" alt="Img produto"></div>
                    <div class="card-body" style="background-color: transparent;">
                        <h5 class="card-title"><?php echo $row['Nome']; ?></h5>
                        <p>€ <?php echo number_format($row['Preco'], 2, '.', ','); ?></p>
                        <label class="CardHoverlabel">Stock: <?php echo $row['Quantidade']; ?></label>

                        <div class="CardHover" >
                            <?php
                                if ($row['Quantidade'] > 0){
                            ?>
                            <div>
                            <input type="number" name="quantidade" id="quantidade-<?php echo $row['id'] ?>" >
                            
                            <input type="hidden" name="Preco" value="<?php echo number_format($row['Preco'], 2, '.', ','); ?>" id="valor-<?php echo $row['id'] ?>">
                            <input type="hidden" name="Nome" value="<?php echo $row['Nome']; ?>" id="nome-<?php echo $row['id'] ?>">
                            <input type="hidden" name="Quantidade" value="<?php echo $row['Quantidade']; ?>" id="quantidade-atual-<?php echo $row['id'] ?>">

                            <button type="submit" class="ButtonCart addToCartButton" data-product-id="<?php echo $row['id'] ?>"><img src="./Icons/icons8-shopping-cart-30.png"  alt="Img produto"></button>
                            </div>
                            <?php
                                } else {
                            ?>
                            <label>Não há stock</label>
                            <?php
                                }
                            ?>
                            <div class ="CardHovInf" id="CardHovInf-<?php echo $row['id'] ?>"></div>
                        </div>      
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p>Não tem produtos.</p>";
        }
        ?>
        </section>
        
    </header>

    <script>
        var carrinho = [];
        var PrecoTotal = 0;

        document.getElementById('meuArrayInput').value = JSON.stringify(carrinho);

        function ConcluirCart() {
            if(carrinho.length > 0){
                document.getElementById('campEcomendas').submit(); 
            }
        }
        function EscluirCart() {
            carrinho = [];
            PrecoTotal = 0;
            var exibicao = document.getElementById('CartProdutos');
            while (exibicao.firstChild) {
                exibicao.removeChild(exibicao.firstChild);
            }
            atualizarQuantidade();
        }

        function AbrirDivInfo() {
            var CartCampo = document.querySelectorAll('.CartCamp');
            
            CartCampo.forEach(function(element) {
                element.classList.add('CardCampOn');
            });
        }
        function FecharDivInfo() {
            var CartCampo = document.querySelectorAll('.CartCamp');
            
            CartCampo.forEach(function(element) {
                element.classList.remove('CardCampOn');
            });
        }

        function atualizarExibicao(array) {
            var exibicao = document.getElementById('CartProdutos');
            exibicao.innerHTML = '';
            PrecoTotal = 0;
            array.forEach(function (item) {
                
                var linha = document.createElement('p');
                linha.textContent = item[3] + ', Quantidade: ' + item[1] + ', Preço: ' + item[2];
                exibicao.appendChild(linha);
                
                var precoUnido = item[2] * item[1];  
               PrecoTotal = PrecoTotal + precoUnido;

            });
            var precoTotalFormatado = PrecoTotal.toFixed(2);
            var totalLinha = document.createElement('p');
            totalLinha.textContent = 'Preço Total: ' + precoTotalFormatado;
            exibicao.appendChild(totalLinha);

            var inputPrecoTotal = document.getElementById('Preco_total');
            inputPrecoTotal.value = precoTotalFormatado;
        }

        function atualizarQuantidade() {
            var quantidadeItens = document.getElementById('CartNumber');
            quantidadeItens.textContent = carrinho.length;
        }

        atualizarQuantidade();

        var addToCartButtons = document.querySelectorAll('.addToCartButton');

        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var produtoId = this.getAttribute('data-product-id');
                var quantidadeInput = document.querySelector('#quantidade-'+produtoId);
                var valorInput = document.querySelector('#valor-'+produtoId);
                var NomeInput = document.querySelector('#nome-'+produtoId);
                var quantidadeAtual = document.querySelector('#quantidade-atual-'+produtoId);
                var exibi= document.getElementById('CardHovInf-'+produtoId);


                if (quantidadeInput) {
                    var quantidade = parseInt(quantidadeInput.value);
                    var valor = valorInput.value;
                    var nome = NomeInput.value;
                    var QAtual = quantidadeAtual.value;

                    if (!isNaN(quantidade) && quantidade > 0) {
                        if (quantidade <= QAtual){
                            carrinho.push([produtoId, quantidade, valor, nome]);
                            atualizarQuantidade();
                            atualizarExibicao(carrinho);
                            document.getElementById('meuArrayInput').value = JSON.stringify(carrinho);

                            quantidadeInput.value = "";
                            valorInput.value = "";
                            while (exibi.firstChild) {
                                exibi.removeChild(exibi.firstChild);
                            }
                        }else{
                            while (exibi.firstChild) {
                                exibi.removeChild(exibi.firstChild);
                            }
                            var aviso = document.createElement('p');
                            aviso.textContent = "Stock atual: " + QAtual;
                            aviso.style.color = 'black'; 

                            exibi.appendChild(aviso);
                        }
                    } else {
                        while (exibi.firstChild) {
                                exibi.removeChild(exibi.firstChild);
                            }
                        var aviso = document.createElement('p');
                            aviso.textContent = "Valor Invalido";
                            aviso.style.color = 'black'; 
                            exibi.appendChild(aviso);

                    }
                } else {
                    console.log("Campo de entrada não encontrado para o produto com ID " + produtoId);
                }
            });
        });
        var mensagem = "<?php echo isset($_GET['mensagem']) ? htmlspecialchars($_GET['mensagem']) : ''; ?>";
        
        if (mensagem) {
            alert(mensagem);
        }
    </script>   


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"crossorigin="anonymous"></script>
</body>
</html>