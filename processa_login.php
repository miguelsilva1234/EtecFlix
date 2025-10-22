<?php 
session_start();

include_once 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];


$consulta = "SELECT * FROM usuario WHERE email = :email AND senha = :senha";

$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->execute();

//$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//var_dump($resultado);

if ($stmt->rowCount() == 1) {
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $_SESSION['id'] = $resultado['id'];
    $_SESSION['nome'] = $resultado['nome'];
    $_SESSION['email'] = $resultado['email'];

    echo "AQUI";
    header('Location: painel.php'); // Página de acesso restrito após login
    exit;
    
} else {
    header('Location: login.php?erro=usuario');
    exit;
}
?>
