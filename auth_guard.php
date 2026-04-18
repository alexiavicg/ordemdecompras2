<?php
// auth_guard.php — Inclua este arquivo no INÍCIO de qualquer página interna
// Uso: require_once 'auth_guard.php';
//
// Garante que apenas usuários autenticados acessem a página.
// Se não houver sessão ativa, redireciona para login.php.

require_once __DIR__ . '/../config/conexao.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}
