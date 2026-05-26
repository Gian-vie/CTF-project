<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DAADS Bank - Login</title>
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
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo h1 {
            font-size: 1.8rem;
            color: var(--neon-purple);
            text-shadow: 0 0 10px var(--neon-glow);
            letter-spacing: 2px;
        }
        .login-logo p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        .login-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--dark);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            color: var(--text);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            border-color: var(--neon-purple);
            box-shadow: 0 0 5px var(--neon-glow);
        }
        .btn-purple {
            width: 100%;
            padding: 0.75rem;
            background: var(--purple);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-purple:hover {
            background: var(--purple-light);
            box-shadow: 0 0 15px var(--neon-glow);
        }
        .error-msg {
            background: rgba(255, 82, 82, 0.1);
            border: 1px solid rgba(255, 82, 82, 0.3);
            color: #ff5252;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-decoration: none;
        }
        .back-link:hover {
            color: var(--neon-purple);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>DAADS BANK</h1>
            <p>Acesse sua conta</p>
        </div>
        <!-- - TODO: remover conta de teste admin@daads.com -->

        <div class="login-card">
            @if ($errors->any())
                <div class="error-msg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('bank.login.submit') }}">
                @csrf
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-purple">Entrar</button>
            </form>
        </div>

        <a href="/" class="back-link">&larr; Voltar ao CTF</a>
    </div>
</body>
</html>
