# CTF Project - Resumo do Desenvolvimento

## Visão Geral
Projeto de **Capture The Flag (CTF)** construído com Laravel 9, onde participantes devem invadir um banco fictício (**DAADS Bank**) e encontrar flags escondidas nas vulnerabilidades do sistema.

## Estrutura Atual

### Sistema CTF (Juiz)
- **Página inicial (`/`)** — Landing page escura explicando o que é um CTF, com imagem do banco (`images/banner.png`)
- **Dashboard (`/dashboard`)** — Painel pós-login com história de espionagem e links para o banco e submissão de flags
- **Judge (`/judge`)** — 3 cards simultâneos com dicas e formulários individuais para submeter flags (requer autenticação)
- **Autenticação** — Laravel Breeze (login, registro, perfil) com tema escuro (bg-gray-900, cards bg-gray-800, botões verdes)

### DAADS Bank (Backend Completo)
Banco fictício com autenticação própria (sessão) e 4 páginas:
- **`/bank/login`** — Login do banco (sessão separada do CTF)
- **`/bank`** — Dashboard com saldo dinâmico, cartão, transações reais, comentário HTML com flag
- **`/bank/profile`** — Perfil com XSS, SQL Injection (DB::unprepared), mudança de senha com código no header, encerramento de conta
- **`/bank/caixinha`** — Cofre digital com depósito/resgate dinâmicos
- **`/bank/deleted`** — Tela para contas encerradas (reativar ou deletar permanentemente)
- **Estética:** Rebeca purple + preto com detalhes neon roxo

### Funcionalidade de Encerramento de Conta
- Botão "Encerrar Conta" no perfil (abaixo de informações pessoais) com modal de confirmação
- Só permite encerrar se saldo da conta **e** caixinha estiverem zerados
- Soft delete (`deleted_at` na tabela bank_users)
- Usuários deletados não conseguem fazer login — são redirecionados para tela com opções:
  - **Reativar Conta** — limpa deleted_at e faz login
  - **Deletar Permanentemente** — remove todos os dados (irreversível), com modal de confirmação

## Banco de Dados

| Tabela | Descrição |
|--------|-----------|
| users | Participantes do CTF (Breeze) |
| challenges | 3 desafios com flags secretas |
| submissions | Submissões vinculadas a user_id |
| bank_users | Correntistas do banco (name, email, password, cpf, phone, deleted_at) |
| bank_accounts | Contas bancárias (FK bank_user_id, account_number, agency, balance, type enum) |
| bank_transactions | Transações (FK bank_account_id, type enum, description, amount) |
| bank_caixinhas | Caixinhas (FK bank_account_id, balance, total_yield) |
| bank_secrets | Segredos (key, secret, password — flag SQLi em base64) |

## Correntistas Seedados

| Nome | Email | Senha | Propósito |
|------|-------|-------|-----------|
| João Demo da Silva | joao.demo@email.com | 123456 | Usuário padrão (senha fraca) |
| Maria Oliveira Santos | maria.oliveira@email.com | maria2024 | Dados para IDOR |
| Administrador DAADS | admin@daads.com | admin123 | Default creds |
| Pedro Deletável | pedro.deletavel@email.com | pedro123 | Conta zerada para testar exclusão |

## Decisões Técnicas
- **Competição individual** (sem times) — flags únicas por usuário
- **Vitória:** primeiro a submeter todas as flags
- **Comparação de flags:** `hash_equals()` (timing-safe)
- **Submissão duplicada bloqueada** por user_id + challenge_id
- **Auth do banco:** sessão separada (`bank_user_id`), middleware `bank.auth`
- **SQL Injection:** `DB::unprepared()` no campo nome (bypass prepared statements)
- **Soft delete:** coluna `deleted_at` em bank_users (não usa SoftDeletes trait do Laravel)

## Ambiente
- **PHP:** 8.0.30 (XAMPP) em `C:\xampp\php\php.exe`
- **Composer:** `C:\Users\service32\composer\composer.phar`
- **Node:** `C:\Program Files\nodejs`
- **Banco:** MariaDB (XAMPP), porta **3307**, database `laravel`, user `root`, sem senha
- **Comando composer:** `C:\xampp\php\php.exe C:\Users\service32\composer\composer.phar [comando]`
- **Vite build:** `$env:PATH = "C:\Program Files\nodejs;" + $env:PATH; npx vite build`

## Arquitetura

```
app/Http/Controllers/Bank/
├── BankAuthController.php       (login, logout, showDeleted, reactivate, permanentDelete)
├── BankDashboardController.php  (index com dados dinâmicos)
├── BankProfileController.php    (index, update/SQLi, passwordRequest/Confirm/Resend/Cancel, deleteAccount)
└── BankCaixinhaController.php   (index, deposit, withdraw)

app/Http/Middleware/
└── BankAuth.php                 (verifica session('bank_user_id'))

app/Models/
├── BankUser.php        (bank_users — hasMany accounts)
├── BankAccount.php     (bank_accounts — belongsTo user, hasMany transactions, hasOne caixinha)
├── Transaction.php     (bank_transactions — belongsTo account)
└── Caixinha.php        (bank_caixinhas — belongsTo account)

resources/views/bank/
├── login.blade.php
├── dashboard.blade.php
├── profile.blade.php
├── caixinha.blade.php
├── layout.blade.php     (sidebar com dados dinâmicos)
└── deleted.blade.php    (tela de conta encerrada)
```

## Flags (3 no total)

| # | Flag | Vulnerabilidade | Como encontrar |
|---|------|-----------------|----------------|
| 1 | `FLAG{html_source_hidden_comment_4d3f}` | Information Disclosure | Comentário HTML no source do dashboard |
| 2 | `FLAG{intercepted_verification_code_7e2a}` | Broken Authentication | Código de verificação exposto no header `X-Verification-Code` ao alterar senha |
| 3 | `FLAG{sqli_raw_query_exposed_e5d8}` | SQL Injection | Injetar SQL no campo nome do perfil para extrair da tabela bank_secrets (hint ROT13 no código-fonte) |

## Rotas do Banco

```
GET  /bank/login              — Tela de login
POST /bank/login              — Autenticar
POST /bank/logout             — Deslogar
GET  /bank/deleted            — Tela conta encerrada
POST /bank/reactivate         — Reativar conta
DELETE /bank/permanent-delete — Deletar permanentemente
GET  /bank                    — Dashboard (protegida)
GET  /bank/profile            — Perfil (protegida)
POST /bank/profile            — Atualizar perfil/SQLi (protegida)
DELETE /bank/profile          — Encerrar conta (protegida)
POST /bank/profile/password-* — Fluxo de alteração de senha (protegida)
GET  /bank/caixinha           — Caixinha (protegida)
POST /bank/caixinha/depositar — Depositar (protegida)
POST /bank/caixinha/resgatar  — Resgatar (protegida)
```

## Tema Visual
- **CTF/Juiz:** Fundo escuro (gray-900), textos verdes (#00ff41), estilo hacker
- **Painel autenticado (Breeze):** bg-gray-900, cards bg-gray-800, botões/links verdes
- **DAADS Bank:** Rebeca purple (#663399), preto (#0a0a0a), neon roxo (#b347d9), sidebar fixa
