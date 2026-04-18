<?php
require_once 'conexao.php';
session_start();
// ── Verificação de sessão ────────────────────────────────────────
if (empty($_SESSION['usuario_logado'])) {
    // Usuário não autenticado → redireciona para o login
    header('Location: login.php');
    exit;
}

// Usuário autenticado
$nomeUsuario = htmlspecialchars($_SESSION['usuario_logado']);

// ── Opção 1 (RECOMENDADO se o sistema externo aceitar redirect):
// Redirecionar diretamente para o sistema já hospedado.
// Descomente a linha abaixo e APAGUE todo o restante deste arquivo
// caso queira fazer um redirect puro:
//
// header('Location: https://alexiavicg.github.io/ordem-de-compras/index.html');
// exit;

// ── Opção 2 (PADRÃO): Página de portal com iframe embeddado ─────
// Exibe o sistema externo dentro desta página protegida,
// mantendo o header de sessão visível ao usuário.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistema de Compras — OC</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --ink:    #0d1117;
    --paper:  #f5f3ee;
    --accent: #1a56db;
    --muted:  #6b7280;
    --border: #d1cfc8;
    --card:   #ffffff;
    --radius: 10px;
    --mono:   'JetBrains Mono', monospace;
    --sans:   'Sora', sans-serif;
  }
  body {
    font-family: var(--sans);
    background: var(--paper);
    color: var(--ink);
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  /* ── TOPBAR ── */
  .topbar {
    background: var(--card);
    border-bottom: 1px solid var(--border);
    padding: .75rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    z-index: 10;
  }
  .topbar-left {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .topbar-logo {
    font-family: var(--mono);
    font-size: .85rem;
    font-weight: 500;
    color: var(--ink);
    letter-spacing: -.01em;
  }
  .topbar-divider {
    width: 1px;
    height: 20px;
    background: var(--border);
  }
  .topbar-title {
    font-size: .88rem;
    color: var(--muted);
    font-weight: 300;
  }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .user-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(26,86,219,.08);
    border: 1px solid rgba(26,86,219,.2);
    padding: 5px 12px;
    border-radius: 100px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--accent);
  }
  .user-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #16a34a;
    flex-shrink: 0;
    animation: pulse 2s ease infinite;
  }

  .btn-logout {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    background: transparent;
    font-family: var(--sans);
    font-size: .8rem;
    font-weight: 600;
    color: var(--muted);
    cursor: pointer;
    text-decoration: none;
    transition: border-color .15s, color .15s, background .15s;
  }
  .btn-logout:hover {
    border-color: #dc2626;
    color: #dc2626;
    background: rgba(220,38,38,.05);
  }

  /* ── IFRAME ── */
  .frame-wrapper {
    flex: 1;
    overflow: hidden;
    position: relative;
  }
  iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
  }

  /* Loading overlay */
  .loading {
    position: absolute;
    inset: 0;
    background: var(--paper);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    z-index: 5;
    transition: opacity .4s;
  }
  .loading.hidden { opacity: 0; pointer-events: none; }
  .loading-spinner {
    width: 36px; height: 36px;
    border: 3px solid var(--border);
    border-top-color: var(--accent);
    border-radius: 50%;
    animation: spin .8s linear infinite;
  }
  .loading p {
    font-size: .85rem;
    color: var(--muted);
    font-weight: 300;
  }

  @keyframes spin  { to { transform: rotate(360deg); } }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>
</head>
<body>

<!-- ── BARRA SUPERIOR ── -->
<header class="topbar">
  <div class="topbar-left">
    <span class="topbar-logo">OC • Sistema</span>
    <div class="topbar-divider"></div>
    <span class="topbar-title">Ordem de Compras</span>
  </div>

  <div class="topbar-right">
    <div class="user-chip">
      <div class="user-dot"></div>
      <?= $nomeUsuario ?>
    </div>
    <a href="logout.php" class="btn-logout">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      Sair
    </a>
  </div>
</header>

<!-- ── SISTEMA EMBEDDADO ── -->
<div class="frame-wrapper">
  <div class="loading" id="loading">
    <div class="loading-spinner"></div>
    <p>Carregando o sistema...</p>
  </div>
  <iframe
    id="sys-frame"
    src="https://alexiavicg.github.io/ordem-de-compras/index.html"
    title="Sistema de Ordem de Compras"
    onload="document.getElementById('loading').classList.add('hidden')"
    allow="downloads; clipboard-write"
  ></iframe>
</div>

</body>
</html>
