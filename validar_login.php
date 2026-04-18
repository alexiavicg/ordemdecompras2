<?php

session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';

if (empty($usuario) || empty($senha)) {
    $erro = 'Preencha o usuário e a senha.';
    include 'login.php';
    exit;
}

$stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE nome = ? LIMIT 1');
$stmt->execute([$usuario]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha'])) {

    session_regenerate_id(true);

    $_SESSION['usuario_logado'] = $user['nome'];
    $_SESSION['usuario_id'] = $user['id'];

    header('Location: sistema.php');
    exit;

} else {
    $erro = 'Usuário ou senha incorretos.';
    include 'login.php';
    exit;
}