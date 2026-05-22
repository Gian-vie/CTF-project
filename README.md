# 🛡️ Planejamento de Projeto: DAADS-Bank CTF (MVP)

Este documento detalha o contexto e a estrutura técnica para o desenvolvimento de um sistema de Capture The Flag (CTF) estilo simulador, focado em vulnerabilidades web, para um projeto acadêmico do **DAADS (Diretório Acadêmico de Análise e Desenvolvimento de Sistemas)**.

---

## 🎯 Objetivo
Desenvolver uma prova de conceito (MVP) que demonstre a capacidade de gerenciar o progresso de segurança de um aluno através de uma plataforma controlada, integrando desafios práticos de cibersegurança em um ambiente bancário fictício.

## 🏗️ Arquitetura de Sistema: "2 em 1"
O projeto será construído em um único repositório **Laravel**, utilizando rotas isoladas para separar as duas entidades do ecossistema:

1.  **O Juiz (Site Principal - `/`)**: 
    *   Interface para o aluno (Frontend em Vue 3).
    *   Gerenciamento de autenticação e progresso.
    *   Validação de submissão de flags dinâmicas.
    *   Exibição de dicas graduais.

2.  **O Alvo (DAADS-Bank - `/lab`)**:
    *   Simulador de banco digital (estilo Fintech).
    *   Ambiente propositalmente vulnerável.
    *   Contém páginas de Home e "Caixinhas" (estilo Nubank).

---

## 🚩 Desafios do MVP (Flags)

O MVP consistirá em 3 flags geradas dinamicamente para cada usuário, garantindo que o código encontrado pelo Aluno A não funcione para o Aluno B.

| Nível | Vulnerabilidade | Descrição da Exploração |
| :--- | :--- | :--- |
| **Fácil 01** | Reconhecimento HTML | A flag está escondida em um comentário de desenvolvedor no código-fonte da página inicial do banco. |
| **Fácil 02** | Falha de Configuração | O aluno deve acessar o arquivo `/lab/robots.txt` para encontrar o caminho de um diretório oculto que contém a flag. |
| **Média 03** | IDOR (Broken Access Control) | Na página de **Caixinhas**, o aluno manipula o ID na URL (ex: `/lab/caixinha/12`) para acessar a caixinha de outro usuário e ler a flag. |

---

## 🛠️ Especificações Técnicas

### Stack Tecnológica
- **Backend:** Laravel 11 (PHP 8.2+).
- **Frontend:** Vue 3 (Composition API).
- **Banco de Dados:** MySQL ou SQLite (com conexões isoladas para Juiz e Lab).
- **Hospedagem:** Foco em custo zero (Render, Koyeb ou Fly.io).

### Pilares de Cibersegurança Aplicados
- **Integridade:** Uso de hashes para validação de flags e proteção de dados no banco de dados.
- **Confidencialidade:** Flags dinâmicas geradas via `FlagService` baseadas no ID do usuário + Secret Salt.
- **Disponibilidade:** Isolamento lógico entre o ambiente de ataque (`/lab`) e o ambiente de gerenciamento (`/`).

---

## 🚀 Próximos Passos
1.  **Modelagem do Banco:** Criar migrations para `users`, `user_flags` e `bank_accounts`.
2.  **Desenvolvimento do Service:** Implementar a lógica de geração de hashes dinâmicos.
3.  **Frontend Vue:** Criar o dashboard do Juiz e a interface simulada do DAADS-Bank.
4.  **Implementação de Falhas:** Codificar as rotas vulneráveis ignorando as proteções nativas do Laravel propositalmente nos locais definidos.

---
*Projeto desenvolvido para fins educacionais - DAADS 2026*