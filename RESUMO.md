# CTF Project - Resumo do Desenvolvimento

## Visão Geral
Projeto de **Capture The Flag (CTF)** construído com Laravel 9, onde participantes devem invadir um banco fictício (**DAADS Bank**) e encontrar flags escondidas nas vulnerabilidades do sistema.

## Estrutura Atual

### Sistema CTF (Juiz)
- **Página inicial (`/`)** — Landing page escura explicando o que é um CTF, com imagem mockada do banco
- **Dashboard (`/dashboard`)** — Painel pós-login com história de espionagem e links para o banco e submissão de flags
- **Judge (`/judge`)** — Formulário para submeter flags (requer autenticação)
- **Autenticação** — Laravel Breeze (login, registro, perfil) com tema escuro

### DAADS Bank (Mock Frontend)
Banco fictício com 3 páginas (apenas views por enquanto):
- **`/bank`** — Dashboard com saldo, cartão, transações
- **`/bank/profile`** — Perfil do correntista com formulários
- **`/bank/caixinha`** — Cofre digital com depósito/resgate/histórico
- **Estética:** Rebeca purple + preto com detalhes neon roxo

## Banco de Dados

| Tabela | Descrição |
|--------|-----------|
| users | Participantes do CTF (Breeze) |
| challenges | Desafios com flags secretas |
| submissions | Submissões vinculadas a user_id |

## Decisões Técnicas
- **Competição individual** (sem times) — flags únicas por usuário
- **Vitória:** primeiro a submeter todas as flags
- **Comparação de flags:** `hash_equals()` (timing-safe)
- **Submissão duplicada bloqueada** por user_id + challenge_id

## Ambiente
- **PHP:** 8.0.30 (XAMPP) em `C:\xampp\php\php.exe`
- **Composer:** `C:\Users\service32\composer\composer.phar`
- **Node:** `C:\Program Files\nodejs`
- **Banco:** MySQL (XAMPP), database `laravel`, user `root`, sem senha
- **Comando composer:** `C:\xampp\php\php.exe C:\Users\service32\composer\composer.phar [comando]`
- **Vite build:** `$env:PATH = "C:\Program Files\nodejs;" + $env:PATH; npx vite build`

## Backend do Banco (A Implementar)

```
app/Http/Controllers/Bank/
├── BankAuthController.php
├── BankDashboardController.php
├── BankProfileController.php
└── BankCaixinhaController.php

Models/
├── BankUser.php        (bank_users)
├── BankAccount.php     (bank_accounts)
├── Transaction.php     (bank_transactions)
└── Caixinha.php        (bank_caixinhas)
```

## Vulnerabilidades Planejadas (Flags)

| Página | Tipo | Onde |
|--------|------|------|
| Login | Brute Force / Default Creds | Credenciais padrão |
| Dashboard | IDOR | Manipulação de ID para ver dados alheios |
| Profile | XSS / SQL Injection | Campo sem sanitização |
| Caixinha | Broken Access Control | Request manipulado |
| Geral | Info Disclosure | Comentário HTML / Header HTTP |

## Tema Visual
- **CTF/Juiz:** Fundo escuro (gray-900), textos verdes (#00ff41), estilo hacker
- **Painel autenticado:** bg-gray-900, nav bg-gray-800, botões verdes
- **DAADS Bank:** Rebeca purple (#663399), preto, neon roxo (#b347d9)
