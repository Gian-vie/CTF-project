<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DAADS Bank - Conta Encerrada</title>
    <style>
        :root {
            --purple: #663399;
            --purple-light: #7b52ab;
            --neon-purple: #b347d9;
            --neon-glow: rgba(179, 71, 217, 0.6);
            --black: #0a0a0a;
            --dark: #121212;
            --dark-card: #1a1a1a;
            --dark-border: #2a2a2a;
            --text: #e0e0e0;
            --text-muted: #888;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--black);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            text-align: center;
        }
        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        h1 {
            color: #ff5252;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        .warning {
            background: rgba(255,82,82,0.1);
            border: 1px solid rgba(255,82,82,0.3);
            color: #ff5252;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        .actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .btn-reactivate {
            background: var(--purple);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-reactivate:hover {
            background: var(--purple-light);
        }
        .btn-delete {
            background: none;
            border: 1px solid #ff5252;
            color: #ff5252;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-delete:hover {
            background: rgba(255,82,82,0.1);
        }
        .btn-back {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: underline;
            margin-top: 1rem;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .modal-content {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .modal-content h3 {
            color: #ff5252;
            margin-bottom: 1rem;
        }
        .modal-content p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .modal-cancel {
            background: var(--dark);
            border: 1px solid var(--dark-border);
            color: var(--text-muted);
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }
        .modal-confirm {
            background: #ff5252;
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⚠️</div>
        <h1>Conta Encerrada</h1>
        <p class="description">
            Esta conta foi encerrada e não pode ser acessada. Você pode reativá-la para voltar a usar normalmente, ou deletá-la permanentemente.
        </p>

        <div class="warning">
            Uma vez deletada permanentemente, todos os dados serão removidos e <strong>não poderão ser recuperados</strong>.
        </div>

        <div class="actions">
            <form method="POST" action="{{ route('bank.reactivate') }}">
                @csrf
                <button type="submit" class="btn-reactivate" style="width: 100%;">Reativar Conta</button>
            </form>

            <button type="button" class="btn-delete" onclick="document.getElementById('permanent-modal').style.display='flex'">
                Deletar Permanentemente
            </button>

            <a href="{{ route('bank.login') }}">
                <button type="button" class="btn-back">Voltar ao login</button>
            </a>
        </div>
    </div>

    {{-- Modal de confirmação de exclusão permanente --}}
    <div id="permanent-modal" class="modal-overlay">
        <div class="modal-content">
            <h3>Deletar Permanentemente</h3>
            <p>Esta ação é <strong>irreversível</strong>. Todos os seus dados, transações e histórico serão apagados definitivamente.</p>
            <div class="modal-actions">
                <button class="modal-cancel" onclick="document.getElementById('permanent-modal').style.display='none'">Cancelar</button>
                <form method="POST" action="{{ route('bank.permanent.delete') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-confirm">Sim, deletar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
