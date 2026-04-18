  <?php
require_once 'conexao.php';
session_start();
?>

  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — OC Sistema</title>
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
      --error:  #dc2626;
      --ok:     #16a34a;
      --radius: 12px;
      --mono:   'JetBrains Mono', monospace;
      --sans:   'Sora', sans-serif;
    }
    body {
      font-family: var(--sans);
      background: var(--paper);
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(26,86,219,.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(26,86,219,.05) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
    }
    body::after {
      content: '';
      position: fixed;
      bottom: -200px; left: -150px;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(26,86,219,.08) 0%, transparent 65%);
      pointer-events: none;
    }

    .container {
      width: 100%;
      max-width: 420px;
      position: relative;
      z-index: 1;
      animation: fadeUp .5s ease both;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: .82rem;
      color: var(--muted);
      text-decoration: none;
      margin-bottom: 1.5rem;
      transition: color .15s;
    }
    .back-link:hover { color: var(--accent); }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 4px 40px rgba(0,0,0,.06);
    }

    .card-header {
      margin-bottom: 2rem;
      text-align: center;
    }
    .card-header .logo {
      font-family: var(--mono);
      font-size: .82rem;
      color: var(--accent);
      font-weight: 500;
      letter-spacing: .04em;
      display: block;
      margin-bottom: .75rem;
    }
    .card-header .avatar {
      width: 56px; height: 56px;
      background: rgba(26,86,219,.1);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.4rem;
    }
    .card-header h1 {
      font-size: 1.65rem;
      font-weight: 700;
      letter-spacing: -.025em;
      margin-bottom: .3rem;
    }
    .card-header p {
      font-size: .88rem;
      color: var(--muted);
      font-weight: 300;
    }

    .alert {
      padding: 10px 14px;
      border-radius: 8px;
      font-size: .85rem;
      margin-bottom: 1.25rem;
    }
    .alert.error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--error); }
    .alert.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--ok); }

    .form-group {
      margin-bottom: 1.2rem;
    }
    label {
      display: block;
      font-size: .83rem;
      font-weight: 600;
      margin-bottom: .45rem;
      letter-spacing: -.005em;
    }
    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 11px 14px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      font-family: var(--sans);
      font-size: .93rem;
      color: var(--ink);
      background: var(--paper);
      outline: none;
      transition: border-color .15s, box-shadow .15s;
    }
    input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(26,86,219,.12);
      background: #fff;
    }

    .btn-submit {
      width: 100%;
      padding: 13px;
      background: var(--ink);
      color: #fff;
      border: none;
      border-radius: var(--radius);
      font-family: var(--sans);
      font-size: .95rem;
      font-weight: 600;
      cursor: pointer;
      transition: background .18s, transform .12s;
      margin-top: .5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-submit:hover  { background: #1e2a3a; transform: translateY(-1px); }
    .btn-submit:active { transform: scale(.99); }

    .spinner {
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,.3);
      border-top-color: #fff;
      border-radius: 50%;
      display: none;
      animation: spin .6s linear infinite;
    }

    .divider {
      text-align: center;
      font-size: .78rem;
      color: var(--muted);
      margin: 1.25rem 0;
      position: relative;
    }
    .divider::before, .divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 40%;
      height: 1px;
      background: var(--border);
    }
    .divider::before { left: 0; }
    .divider::after  { right: 0; }

    .footer-note {
      text-align: center;
      font-size: .83rem;
      color: var(--muted);
      font-weight: 300;
    }
    .footer-note a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
    }
    .footer-note a:hover { text-decoration: underline; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
  </head>
  <body>

<?php

  // Se já está logado, vai direto ao sistema
  if (!empty($_SESSION['usuario_logado'])) {
      header('Location: sistema.php');
      exit;
  }

  // Mensagem de sucesso vinda do cadastro
  $msgSucesso = $_SESSION['msg_sucesso'] ?? '';
  unset($_SESSION['msg_sucesso']);
  ?>

  <div class="container">
    <a href="index.php" class="back-link">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
      Início
    </a>

    <div class="card">
      <div class="card-header">
        <span class="logo">OC • Sistema de Compras</span>
        <div class="avatar">🔐</div>
        <h1>Bem-vindo!</h1>
        <p>Entre com suas credenciais para acessar o sistema.</p>
      </div>

      <?php if ($msgSucesso): ?>
        <div class="alert success"><?= htmlspecialchars($msgSucesso) ?></div>
      <?php endif; ?>

      <?php if (!empty($erro)): ?>
        <div class="alert error"><?= htmlspecialchars($erro) ?></div>
      <?php endif; ?>

      <form id="form-login" action="validar_login.php" method="POST">
        <div class="form-group">
          <label for="usuario">Usuário</label>
          <input type="text" id="usuario" name="usuario"
                placeholder="Seu nome de usuário"
                autocomplete="username"
                value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>"
                required>
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha"
                placeholder="Sua senha"
                autocomplete="current-password"
                required>
        </div>

        <button type="submit" class="btn-submit" id="btn-login">
          <span>Entrar</span>
          <div class="spinner" id="spinner"></div>
          <svg id="arrow-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </form>

      <div class="divider">ou</div>

      <p class="footer-note">
        Não tem conta ainda? <a href="cadastro.php">Criar conta</a>
      </p>
    </div>
  </div>

  <script>
  document.getElementById('form-login').addEventListener('submit', function() {
    document.getElementById('spinner').style.display    = 'block';
    document.getElementById('arrow-icon').style.display = 'none';
    document.getElementById('btn-login').disabled       = true;
  });
  </script>
  </body>
  </html>
