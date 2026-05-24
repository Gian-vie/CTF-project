<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CTF - Capture The Flag</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Nunito', sans-serif;
                background: #111827;
                color: #e5e7eb;
                min-height: 100vh;
            }
            .nav {
                position: fixed;
                top: 0;
                right: 0;
                padding: 1.5rem;
                z-index: 10;
            }
            .nav a {
                font-size: 0.875rem;
                color: #9ca3af;
                text-decoration: underline;
                margin-left: 1rem;
                transition: color 0.2s;
            }
            .nav a:hover {
                color: #00ff41;
            }
            .hero {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 4rem 1.5rem 2rem;
                max-width: 900px;
                margin: 0 auto;
            }
            .bank-image {
                width: 100%;
                max-width: 600px;
                height: 300px;
                background: #1f2937;
                border: 1px solid #374151;
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 3rem;
                overflow: hidden;
                box-shadow: 0 0 30px rgba(0, 255, 65, 0.05);
            }
            .bank-image span {
                color: #4b5563;
                font-size: 1rem;
            }
            .content h1 {
                font-size: 2.5rem;
                font-weight: 700;
                color: #00ff41;
                margin-bottom: 1rem;
                text-align: center;
                text-shadow: 0 0 10px rgba(0, 255, 65, 0.3);
            }
            .content h2 {
                font-size: 1.25rem;
                font-weight: 600;
                color: #d1d5db;
                margin-bottom: 1.5rem;
                text-align: center;
            }
            .content p {
                font-size: 1rem;
                line-height: 1.75;
                color: #9ca3af;
                margin-bottom: 1rem;
                text-align: center;
            }
            .content .highlight {
                color: #00ff41;
                font-weight: 600;
            }
            .card {
                background: #1f2937;
                border: 1px solid #374151;
                border-radius: 0.75rem;
                padding: 2rem;
                margin-top: 2rem;
                width: 100%;
            }
            .card h3 {
                color: #f3f4f6;
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .card ul {
                list-style: none;
                padding: 0;
            }
            .card ul li {
                padding: 0.5rem 0;
                color: #9ca3af;
                font-size: 0.95rem;
                border-bottom: 1px solid #374151;
            }
            .card ul li:last-child {
                border-bottom: none;
            }
            .card ul li span {
                color: #00ff41;
                margin-right: 0.5rem;
            }
            .footer {
                text-align: center;
                padding: 2rem;
                color: #4b5563;
                font-size: 0.8rem;
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            <div class="nav">
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="hero">
            <div class="bank-image">
                {{-- Substituir pelo asset real do banco posteriormente --}}
                <span>[ Imagem do Banco - DAADS Bank ]</span>
            </div>

            <div class="content">
                <h1>Capture The Flag</h1>
                <h2>Teste suas habilidades em segurança cibernética</h2>

                <p>
                    Um <span class="highlight">CTF (Capture The Flag)</span> é uma competição de segurança da informação onde participantes resolvem desafios para encontrar "flags" — códigos secretos escondidos em sistemas vulneráveis.
                </p>
                <p>
                    Os desafios simulam cenários reais de ataque e defesa, cobrindo áreas como <span class="highlight">exploração web</span>, <span class="highlight">criptografia</span>, <span class="highlight">engenharia reversa</span>, <span class="highlight">forense digital</span> e muito mais.
                </p>
                <p>
                    Neste CTF, você será desafiado a invadir o sistema do <span class="highlight">DAADS Bank</span> — um banco fictício com vulnerabilidades propositais. Encontre as brechas, capture as flags e prove seu valor.
                </p>
            </div>

            <div class="card">
                <h3>Como funciona?</h3>
                <ul>
                    <li><span>1.</span> Registre-se ou faça login</li>
                    <li><span>2.</span> Acesse o sistema do banco alvo pelo painel</li>
                    <li><span>3.</span> Explore vulnerabilidades e encontre as flags</li>
                    <li><span>4.</span> Submeta suas flags para pontuar</li>
                    <li><span>5.</span> O primeiro a submeter todas as flags vence!</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            CTF Project &mdash; Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        </div>
    </body>
</html>
