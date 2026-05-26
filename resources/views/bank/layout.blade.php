<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DAADS Bank - @yield('title', 'Home')</title>
    <style>
        :root {
            --purple: #663399;
            --purple-light: #7b52ab;
            --purple-dark: #4a2070;
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
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: var(--dark);
            border-right: 1px solid var(--dark-border);
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-logo {
            text-align: center;
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid var(--dark-border);
        }
        .sidebar-logo h1 {
            font-size: 1.4rem;
            color: var(--neon-purple);
            text-shadow: 0 0 10px var(--neon-glow);
            letter-spacing: 2px;
        }
        .sidebar-logo span {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .sidebar-nav {
            list-style: none;
            padding: 1.5rem 0;
            flex: 1;
        }
        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            color: var(--neon-purple);
            background: rgba(102, 51, 153, 0.1);
            border-left-color: var(--neon-purple);
        }
        .sidebar-nav li a svg {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            fill: currentColor;
        }
        .sidebar-user {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--dark-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-user .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .sidebar-user .info {
            font-size: 0.8rem;
        }
        .sidebar-user .info .name {
            color: var(--text);
            font-weight: 600;
        }
        .sidebar-user .info .role {
            color: var(--text-muted);
            font-size: 0.7rem;
        }
        .sidebar-logout {
            padding: 0.75rem 1.5rem;
        }
        .sidebar-logout button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: 1px solid var(--dark-border);
            color: var(--text-muted);
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .sidebar-logout button:hover {
            border-color: #ff5252;
            color: #ff5252;
            background: rgba(255,82,82,0.08);
        }
        .sidebar-logout button svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }
        /* Main content */
        .main {
            margin-left: 240px;
            padding: 2rem;
            min-height: 100vh;
        }
        .page-header {
            margin-bottom: 2rem;
        }
        .page-header h2 {
            font-size: 1.5rem;
            color: var(--text);
            font-weight: 600;
        }
        .page-header p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }
        /* Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--purple), var(--neon-purple), var(--purple));
            box-shadow: 0 0 10px var(--neon-glow), 0 0 20px var(--neon-glow);
        }
        .card-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        .card-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text);
        }
        .card-value.purple {
            color: var(--neon-purple);
            text-shadow: 0 0 8px var(--neon-glow);
        }
        .card-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        /* Table */
        .panel {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .panel::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-purple), transparent);
            box-shadow: 0 0 8px var(--neon-glow);
        }
        .panel h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: var(--text);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            text-align: left;
            padding: 0.75rem;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--dark-border);
        }
        table th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
        }
        table td {
            color: var(--text);
        }
        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-success {
            background: rgba(0, 200, 83, 0.15);
            color: #00c853;
        }
        .badge-pending {
            background: rgba(179, 71, 217, 0.15);
            color: var(--neon-purple);
        }
        /* Form styles */
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--dark);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--neon-purple);
            box-shadow: 0 0 5px rgba(179, 71, 217, 0.2);
        }
        .btn-purple {
            padding: 0.75rem 2rem;
            background: var(--purple);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-purple:hover {
            background: var(--purple-light);
            box-shadow: 0 0 15px var(--neon-glow);
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>DAADS</h1>
            <span>Digital Bank</span>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="/bank" class="@yield('nav-dashboard')">
                    <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/bank/profile" class="@yield('nav-profile')">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    Perfil
                </a>
            </li>
            <li>
                <a href="/bank/caixinha" class="@yield('nav-caixinha')">
                    <svg viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    Caixinha
                </a>
            </li>
        </ul>
        <div class="sidebar-user">
            @php $bankUser = \App\Models\BankUser::find(session('bank_user_id')); @endphp
            <div class="avatar">{{ $bankUser ? strtoupper(substr($bankUser->name, 0, 1)) . strtoupper(substr(explode(' ', $bankUser->name)[1] ?? '', 0, 1)) : 'U' }}</div>
            <div class="info">
                <div class="name">{{ $bankUser ? explode(' ', $bankUser->name)[0] . ' ' . (explode(' ', $bankUser->name)[1] ?? '') : 'Usuário' }}</div>
                <div class="role">Conta Corrente</div>
            </div>
        </div>
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('bank.logout') }}">
                @csrf
                <button type="submit">
                    <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 13H5V4h7V2H5C3.9 2 3 2.9 3 4v16c0 1.1.9 2 2 2h7v-2z"/></svg>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        @yield('content')
    </main>
</body>
</html>
