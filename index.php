<?php
require_once 'conexao.php';
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OC Sistema — Ordem de Compras</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --ink:     #0d1117;
    --paper:   #f5f3ee;
    --accent:  #1a56db;
    --accent2: #0e3fa3;
    --muted:   #6b7280;
    --border:  #d1cfc8;
    --card:    #ffffff;
    --green:   #16a34a;
    --amber:   #d97706;
    --radius:  12px;
    --mono:    'JetBrains Mono', monospace;
    --sans:    'Sora', sans-serif;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: var(--sans);
    background: var(--paper);
    color: var(--ink);
    line-height: 1.65;
    overflow-x: hidden;
  }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 5rem 2rem 4rem;
    position: relative;
    overflow: hidden;
  }

  /* Grid de fundo decorativo */
  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(26,86,219,.06) 1px, transparent 1px),
      linear-gradient(90deg, rgba(26,86,219,.06) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
  }

  /* Círculo de luz */
  .hero::after {
    content: '';
    position: absolute;
    top: -200px;
    right: -200px;
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(26,86,219,.12) 0%, transparent 65%);
    pointer-events: none;
  }

  .hero-inner {
    max-width: 860px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
  }

  .badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(26,86,219,.1);
    color: var(--accent);
    border: 1px solid rgba(26,86,219,.25);
    padding: 5px 14px;
    border-radius: 100px;
    font-size: .78rem;
    font-family: var(--mono);
    font-weight: 500;
    letter-spacing: .04em;
    margin-bottom: 2rem;
    animation: fadeDown .7s ease both;
  }

  .badge::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--accent);
    animation: pulse 2s ease infinite;
  }

  .hero h1 {
    font-size: clamp(2.6rem, 6vw, 5rem);
    font-weight: 700;
    line-height: 1.08;
    letter-spacing: -.03em;
    margin-bottom: 1.5rem;
    animation: fadeDown .7s .12s ease both;
  }

  .hero h1 em {
    font-style: normal;
    color: var(--accent);
    position: relative;
  }

  .hero h1 em::after {
    content: '';
    position: absolute;
    bottom: 2px; left: 0; right: 0;
    height: 3px;
    background: var(--accent);
    opacity: .3;
    border-radius: 2px;
  }

  .hero p {
    font-size: 1.15rem;
    color: var(--muted);
    max-width: 540px;
    margin-bottom: 2.5rem;
    font-weight: 300;
    animation: fadeDown .7s .22s ease both;
  }

  .hero-btns {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    animation: fadeDown .7s .32s ease both;
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--ink);
    color: #fff;
    padding: 14px 28px;
    border-radius: var(--radius);
    font-family: var(--sans);
    font-size: .95rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .18s, transform .14s;
  }
  .btn-primary:hover { background: #1e2a3a; transform: translateY(-2px); }

  .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    color: var(--ink);
    padding: 13px 26px;
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    font-family: var(--sans);
    font-size: .95rem;
    font-weight: 600;
    text-decoration: none;
    transition: border-color .18s, background .18s, transform .14s;
  }
  .btn-secondary:hover { border-color: var(--ink); background: rgba(0,0,0,.04); transform: translateY(-2px); }

  /* ── STATS BAR ── */
  .stats-bar {
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    background: var(--card);
    padding: 1.5rem 2rem;
  }
  .stats-inner {
    max-width: 960px;
    margin: 0 auto;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .stat {
    text-align: center;
  }
  .stat strong {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    font-family: var(--mono);
    color: var(--accent);
    letter-spacing: -.04em;
  }
  .stat span {
    font-size: .82rem;
    color: var(--muted);
    font-weight: 400;
  }

  /* ── SECTIONS ── */
  section {
    padding: 5rem 2rem;
  }
  .section-inner {
    max-width: 960px;
    margin: 0 auto;
  }
  .tag {
    display: inline-block;
    font-family: var(--mono);
    font-size: .72rem;
    font-weight: 500;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--accent);
    background: rgba(26,86,219,.08);
    padding: 4px 10px;
    border-radius: 6px;
    margin-bottom: 1rem;
  }
  h2 {
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 700;
    letter-spacing: -.02em;
    line-height: 1.15;
    margin-bottom: .75rem;
  }
  .section-sub {
    font-size: 1rem;
    color: var(--muted);
    margin-bottom: 3rem;
    max-width: 500px;
    font-weight: 300;
  }

  /* ── BENEFÍCIOS ── */
  .benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.25rem;
  }
  .benefit-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.75rem;
    transition: transform .2s, box-shadow .2s;
  }
  .benefit-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,.08); }
  .benefit-icon {
    font-size: 1.6rem;
    margin-bottom: 1rem;
    display: block;
  }
  .benefit-card h3 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: .4rem;
  }
  .benefit-card p {
    font-size: .88rem;
    color: var(--muted);
    line-height: 1.6;
    font-weight: 300;
  }

  /* ── FUNCIONALIDADES ── */
  .features-bg {
    background: var(--ink);
    color: var(--paper);
  }
  .features-bg .tag {
    color: #7cb4ff;
    background: rgba(124,180,255,.12);
  }
  .features-bg h2 { color: #fff; }
  .features-bg .section-sub { color: rgba(245,243,238,.55); }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
  }
  .feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 1.25rem;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius);
    transition: background .18s;
  }
  .feature-item:hover { background: rgba(255,255,255,.04); }
  .feature-check {
    flex-shrink: 0;
    width: 28px; height: 28px;
    background: rgba(26,86,219,.35);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
  }
  .feature-item h4 {
    font-size: .92rem;
    font-weight: 600;
    color: #f0eeea;
    margin-bottom: 3px;
  }
  .feature-item p {
    font-size: .8rem;
    color: rgba(245,243,238,.5);
    font-weight: 300;
    line-height: 1.5;
  }

  /* ── FRASES DE IMPACTO ── */
  .quotes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
  }
  .quote-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 2rem;
    position: relative;
  }
  .quote-card::before {
    content: '"';
    position: absolute;
    top: 1rem; left: 1.25rem;
    font-size: 5rem;
    color: rgba(26,86,219,.1);
    font-family: Georgia, serif;
    line-height: 1;
  }
  .quote-card blockquote {
    font-size: 1.05rem;
    font-weight: 400;
    line-height: 1.6;
    color: var(--ink);
    margin-bottom: 1rem;
    padding-top: 1rem;
  }
  .quote-author {
    font-family: var(--mono);
    font-size: .78rem;
    color: var(--accent);
    font-weight: 500;
  }

  /* ── CTA ── */
  .cta-section {
    text-align: center;
    padding: 5rem 2rem;
  }
  .cta-box {
    background: var(--ink);
    border-radius: 24px;
    padding: 4rem 2rem;
    max-width: 640px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
  }
  .cta-box::before {
    content: '';
    position: absolute;
    top: -100px; left: 50%;
    transform: translateX(-50%);
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(26,86,219,.3) 0%, transparent 65%);
    pointer-events: none;
  }
  .cta-box h2 {
    color: #fff;
    font-size: clamp(1.6rem, 4vw, 2.4rem);
    margin-bottom: .75rem;
  }
  .cta-box p {
    color: rgba(245,243,238,.6);
    font-size: 1rem;
    margin-bottom: 2rem;
    font-weight: 300;
  }
  .cta-box .btn-primary {
    background: #fff;
    color: var(--ink);
    margin: 0 auto;
  }
  .cta-box .btn-primary:hover { background: #e8e6e0; }

  /* ── RODAPÉ ── */
  footer {
    border-top: 1px solid var(--border);
    padding: 2rem;
    text-align: center;
  }
  .footer-inner {
    max-width: 960px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .footer-logo {
    font-family: var(--mono);
    font-weight: 500;
    font-size: .95rem;
    letter-spacing: -.01em;
    color: var(--ink);
  }
  footer p {
    font-size: .82rem;
    color: var(--muted);
  }
  footer a {
    color: var(--muted);
    text-decoration: none;
    font-size: .82rem;
    transition: color .15s;
  }
  footer a:hover { color: var(--accent); }

  /* ── ANIMATIONS ── */
  @keyframes fadeDown {
    from { opacity: 0; transform: translateY(-14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: .4; }
  }

  /* ── RESPONSIVO ── */
  @media (max-width: 600px) {
    .hero-btns { flex-direction: column; }
    .btn-primary, .btn-secondary { width: 100%; justify-content: center; }
    .footer-inner { flex-direction: column; text-align: center; }
  }
</style>
</head>
<body>

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-inner">
    <span class="badge">v1.0 · Sistema de Gestão</span>

    <h1>Controle total das<br>suas <em>Ordens de Compra</em></h1>

    <p>Cadastre fornecedores, gerencie pedidos, acompanhe status e mantenha o histórico completo das compras da sua empresa — tudo em um só lugar.</p>

    <div class="hero-btns">
      <a href="login.php" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
        Entrar
      </a>
      <a href="cadastro.php" class="btn-secondary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Testar agora
      </a>
    </div>
  </div>
</section>

<!-- ── STATS ── -->
<div class="stats-bar">
  <div class="stats-inner">
    <div class="stat"><strong>100%</strong><span>Web & Responsivo</span></div>
    <div class="stat"><strong>0</strong><span>Instalação necessária</span></div>
    <div class="stat"><strong>∞</strong><span>Ordens de compra</span></div>
    <div class="stat"><strong>1-click</strong><span>Aprovação de pedidos</span></div>
  </div>
</div>

<!-- ── BENEFÍCIOS ── -->
<section>
  <div class="section-inner">
    <span class="tag">Benefícios</span>
    <h2>Por que usar o OC Sistema?</h2>
    <p class="section-sub">Tudo que você precisa para organizar compras sem planilhas, papéis ou retrabalho.</p>

    <div class="benefits-grid">
      <div class="benefit-card">
        <span class="benefit-icon">📋</span>
        <h3>Pedidos organizados</h3>
        <p>Crie ordens de compra estruturadas com todos os dados do fornecedor, produto e prazo em um único formulário.</p>
      </div>
      <div class="benefit-card">
        <span class="benefit-icon">🔒</span>
        <h3>Acesso seguro</h3>
        <p>Autenticação com login e senha protegida. Apenas usuários cadastrados acessam o sistema.</p>
      </div>
      <div class="benefit-card">
        <span class="benefit-icon">📊</span>
        <h3>Histórico completo</h3>
        <p>Consulte todas as ordens emitidas, filtre por status e acompanhe cada etapa do processo de compra.</p>
      </div>
      <div class="benefit-card">
        <span class="benefit-icon">⚡</span>
        <h3>Rápido e leve</h3>
        <p>Interface ágil, sem travamentos. Funciona em qualquer navegador moderno, inclusive no celular.</p>
      </div>
      <div class="benefit-card">
        <span class="benefit-icon">🖨️</span>
        <h3>Impressão e exportação</h3>
        <p>Exporte ordens em JSON ou imprima diretamente com layout profissional pronto para assinatura.</p>
      </div>
      <div class="benefit-card">
        <span class="benefit-icon">🔄</span>
        <h3>Fluxo completo</h3>
        <p>Da requisição à aprovação, do pedido ao recebimento — cada etapa registrada e rastreável.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── FUNCIONALIDADES ── -->
<section class="features-bg">
  <div class="section-inner">
    <span class="tag">Funcionalidades</span>
    <h2>O que o sistema oferece</h2>
    <p class="section-sub">Funcionalidades pensadas para compradores, aprovadores e gestores.</p>

    <div class="features-grid">
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Cadastro de fornecedores</h4>
          <p>Registre e gerencie fornecedores com todos os dados de contato.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Cadastro de produtos</h4>
          <p>Mantenha catálogo atualizado com preços históricos por fornecedor.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Geração de OC</h4>
          <p>Crie ordens de compra numeradas automaticamente com todos os itens.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Fluxo de aprovação</h4>
          <p>Submeta para aprovação e receba notificação de status em tempo real.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Recebimento e NF</h4>
          <p>Registre recebimento de mercadorias e vincule notas fiscais.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Controle de pagamento</h4>
          <p>Acompanhe vencimentos, parcelamentos e centro de custo.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Relatórios gerenciais</h4>
          <p>Extraia relatórios por período, fornecedor, produto e status.</p>
        </div>
      </div>
      <div class="feature-item">
        <div class="feature-check">✓</div>
        <div>
          <h4>Controle de acesso</h4>
          <p>Sessão segura: páginas internas protegidas por autenticação.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── FRASES DE IMPACTO ── -->
<section>
  <div class="section-inner">
    <span class="tag">Frases de impacto</span>
    <h2>O que dizem quem já usa</h2>
    <p class="section-sub">Depoimentos de gestores que transformaram o processo de compras.</p>

    <div class="quotes-grid">
      <div class="quote-card">
        <blockquote>Antes eu gerenciava tudo em planilha. Agora tenho controle real, com histórico e rastreabilidade de cada pedido.</blockquote>
        <span class="quote-author">— Gerente de Compras, Indústria Têxtil</span>
      </div>
      <div class="quote-card">
        <blockquote>A aprovação que demorava dias agora é feita em minutos. O fluxo digital eliminou o papel e o retrabalho.</blockquote>
        <span class="quote-author">— Diretor Financeiro, Distribuidora</span>
      </div>
      <div class="quote-card">
        <blockquote>Implantamos sem precisar de TI. A interface é simples, qualquer comprador aprende em minutos.</blockquote>
        <span class="quote-author">— Coordenador, Setor de Suprimentos</span>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA FINAL ── -->
<section class="cta-section">
  <div class="cta-box">
    <h2>Pronto para começar?</h2>
    <p>Crie sua conta gratuitamente e acesse o sistema de ordens de compra agora mesmo.</p>
    <a href="cadastro.php" class="btn-primary">
      Criar conta grátis →
    </a>
  </div>
</section>

<!-- ── RODAPÉ ── -->
<footer>
  <div class="footer-inner">
    <span class="footer-logo">OC • Sistema de Compras</span>
    <p>Desenvolvido com PHP &amp; MySQL</p>
    <nav style="display:flex;gap:1.5rem;">
      <a href="login.php">Entrar</a>
      <a href="cadastro.php">Cadastrar</a>
    </nav>
  </div>
</footer>

</body>
</html>
