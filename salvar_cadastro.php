<?php

session_start();
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php');
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

if (empty($usuario) || empty($senha) || empty($confirmar_senha)) {
    $erro = 'Preencha todos os campos.';
} elseif (strlen($usuario) < 3 || strlen($usuario) > 50) {
    $erro = 'O usuário deve ter entre 3 e 50 caracteres.';
} elseif (preg_match('/\s/', $usuario)) {
    $erro = 'O usuário não pode conter espaços.';
} elseif (strlen($senha) < 6) {
    $erro = 'A senha deve ter pelo menos 6 caracteres.';
} elseif ($senha !== $confirmar_senha) {
    $erro = 'As senhas não coincidem.';
} else {

    $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE nome = ? LIMIT 1');
    $stmt->execute([$usuario]);

    if ($stmt->fetch()) {
        $erro = 'Este usuário já existe.';
    } else {

        $hashSenha = password_hash($senha, PASSWORD_BCRYPT);

        $insert = $pdo->prepare('INSERT INTO usuarios (nome, senha) VALUES (?, ?)');
        $insert->execute([$usuario, $hashSenha]);

        $_SESSION['msg_sucesso'] = 'Conta criada com sucesso!';
        header('Location: login.php');
        exit;
    }
}

include 'cadastro.php';