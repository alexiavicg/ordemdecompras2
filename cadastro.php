<?php
require_once 'conexao.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro — OC Sistema</title>
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

  .container {
    width: 100%;
    max-width: 440px;
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
  .card-header h1 {
    font-size: 1.65rem;
    font-weight: 700;
    letter-spacing: -.025em;
    margin-bottom: .35rem;
  }
  .card-header p {
    font-size: .88rem;
    color: var(--muted);
    font-weight: 300;
  }

  .form-group {
    margin-bottom: 1.25rem;
  }
  label {
    display: block;
    font-size: .83rem;
    font-weight: 600;
    color: var(--ink);
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

  .hint {
    font-size: .76rem;
    color: var(--muted);
    margin-top: .35rem;
    font-weight: 300;
  }

  /* strength bar */
  .strength-wrap {
    margin-top: .5rem;
    display: flex;
    gap: 4px;
    align-items: center;
  }
  .strength-bar {
    flex: 1;
    height: 4px;
    background: var(--border);
    border-radius: 2px;
    overflow: hidden;
  }
  .strength-fill {
    height: 100%;
    width: 0;
    border-radius: 2px;
    transition: width .3s, background .3s;
  }
  .strength-label {
    font-size: .72rem;
    color: var(--muted);
    min-width: 50px;
    text-align: right;
    font-family: var(--mono);
  }

  .alert {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: .85rem;
    font-weight: 400;
    margin-bottom: 1.25rem;
    display: none;
  }
  .alert.error  { background: #fef2f2; border: 1px solid #fecaca; color: var(--error); display: block; }
  .alert.success{ background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--ok);    display: block; }

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
  }
  .btn-submit:hover { background: #1e2a3a; transform: translateY(-1px); }
  .btn-submit:active { transform: scale(.99); }

  .footer-note {
    text-align: center;
    font-size: .83rem;
    color: var(--muted);
    margin-top: 1.5rem;
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
</style>
</head>
<body>
<div class="container">
  <a href="index.php" class="back-link">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
    Voltar
  </a>

  <div class="card">
    <div class="card-header">
      <span class="logo">OC • Sistema de Compras</span>
      <h1>Criar conta</h1>
      <p>Preencha os dados abaixo para acessar o sistema.</p>
    </div>

    <!-- Mensagem de erro/sucesso (PHP) -->
    <?php if (!empty($erro)): ?>
      <div class="alert error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <?php if (!empty($sucesso)): ?>
      <div class="alert success"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <!-- Alerta JS (validação client-side) -->
    <div class="alert error" id="js-alert" style="display:none"></div>

    <form id="form-cadastro" action="salvar_cadastro.php" method="POST" novalidate>
      <div class="form-group">
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario"
               placeholder="ex: joao.silva"
               autocomplete="username"
               required minlength="3" maxlength="50">
        <span class="hint">3 a 50 caracteres, sem espaços</span>
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha"
               placeholder="Mínimo 6 caracteres"
               autocomplete="new-password"
               required minlength="6">
        <div class="strength-wrap">
          <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
          <span class="strength-label" id="strength-label">—</span>
        </div>
      </div>

      <div class="form-group">
        <label for="confirmar_senha">Confirmar senha</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha"
               placeholder="Repita a senha"
               autocomplete="new-password"
               required>
      </div>

      <button type="submit" class="btn-submit">Criar conta →</button>
    </form>

    <p class="footer-note">
      Já tem uma conta? <a href="login.php">Entrar</a>
    </p>
  </div>
</div>

<script>
// Força de senha
const senhaInput  = document.getElementById('senha');
const fill        = document.getElementById('strength-fill');
const label       = document.getElementById('strength-label');

senhaInput.addEventListener('input', () => {
  const v   = senhaInput.value;
  let score = 0;
  if (v.length >= 6)  score++;
  if (v.length >= 10) score++;
  if (/[A-Z]/.test(v)) score++;
  if (/[0-9]/.test(v)) score++;
  if (/[^A-Za-z0-9]/.test(v)) score++;

  const map = [
    { pct: '20%', color: '#dc2626', txt: 'Fraca'   },
    { pct: '40%', color: '#ea580c', txt: 'Razoável'},
    { pct: '60%', color: '#d97706', txt: 'Média'   },
    { pct: '80%', color: '#65a30d', txt: 'Boa'     },
    { pct:'100%', color: '#16a34a', txt: 'Forte'   },
  ];
  const m = map[Math.min(score, 4)];
  fill.style.width      = m.pct;
  fill.style.background = m.color;
  label.textContent     = m.txt;
});

// Validação client-side antes do submit
document.getElementById('form-cadastro').addEventListener('submit', function(e) {
  const usuario  = document.getElementById('usuario').value.trim();
  const senha    = document.getElementById('senha').value;
  const confirma = document.getElementById('confirmar_senha').value;
  const alertEl  = document.getElementById('js-alert');

  alertEl.style.display = 'none';
  alertEl.textContent   = '';

  if (usuario.length < 3) {
    e.preventDefault();
    alertEl.textContent   = 'O usuário deve ter pelo menos 3 caracteres.';
    alertEl.style.display = 'block';
    return;
  }
  if (/\s/.test(usuario)) {
    e.preventDefault();
    alertEl.textContent   = 'O usuário não pode conter espaços.';
    alertEl.style.display = 'block';
    return;
  }
  if (senha.length < 6) {
    e.preventDefault();
    alertEl.textContent   = 'A senha deve ter pelo menos 6 caracteres.';
    alertEl.style.display = 'block';
    return;
  }
  if (senha !== confirma) {
    e.preventDefault();
    alertEl.textContent   = 'As senhas não coincidem. Tente novamente.';
    alertEl.style.display = 'block';
  }
});
</script>
</body>
</html>
