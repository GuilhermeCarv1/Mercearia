<?php
session_start();
include('verifica_is_adm.php');
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
        </ul>
    </nav>
    <div class="container-fluid CampoTopLogin"></div>
    <div class="CampoTopLoginInter">
        <h1>Welcome!</h1>
        <h6>Today Will be great</h6>
        <form action="processarLogin.php" method="post">
            <div>
                <img src="./Icons/icons8-user-50.png" alt="Icon User">
                <input type="text" name="username" id="username" placeholder="Username" required >
            </div>
            <div>
                <img src="./Icons/icons8-lock-64.png" alt="Icon Lock">
                <input type="password" name="password" id="password" placeholder="password" required>
            </div>
            <button class="ButtonMaster" type="submit">LOGIN</button>
        </form>
    </div>
    <script>
        var mensagem = "<?php echo isset($_GET['mensagem']) ? htmlspecialchars($_GET['mensagem']) : ''; ?>";
        
        if (mensagem) {
            alert(mensagem);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"crossorigin="anonymous"></script>
</body>
</html>