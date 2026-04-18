<?php
require_once 'conexao.php';
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = [];

// Invalida o cookie de sessão
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destrói a sessão no servidor
session_destroy();

// Redireciona para a tela de login com mensagem
header('Location: login.php?logout=1');
exit;
