<?php
session_start();

include 'conexao.php';

function buscarUsuario() {
    global $conexao;
    $query = "SELECT * FROM utilizadores";
    $result = mysqli_query($conexao, $query);

    if (!$result) {
        die("Erro na busca de dados: " . mysqli_error($conexao));
    }

    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usuarios = buscarUsuario();

    foreach ($usuarios as $usuario) {
        if ($usuario['Name'] == $username &&  $usuario['Password'] ==  $password) {
            $_SESSION['usuario'] = $usuario['Name'];
            $mensagem = "Olá " . $usuario['Name'];
            header("Location: HOME.php?mensagem=" . urlencode($mensagem));
            exit();
        }
    }
    $mensagem = "Credenciais inválidas. Tente novamente.";
}
header("Location: LOGIN.php?mensagem=" . urlencode($mensagem));

?>
