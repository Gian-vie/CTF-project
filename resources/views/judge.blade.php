<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CTF - Submissão de Flags</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0a;
            color: #00ff41;
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 0 0 10px #00ff41;
        }
        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 40px;
        }
        .challenges-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .challenge-card {
            background: #111;
            border: 1px solid #222;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 0 10px rgba(0, 255, 65, 0.05);
            transition: border-color 0.3s;
        }
        .challenge-card:hover {
            border-color: #00ff41;
        }
        .challenge-card.solved {
            border-color: #00ff41;
            background: rgba(0, 255, 65, 0.03);
        }
        .challenge-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .challenge-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #00ff41;
        }
        .challenge-points {
            font-size: 0.85rem;
            color: #ffa500;
            background: rgba(255, 165, 0, 0.1);
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid rgba(255, 165, 0, 0.3);
        }
        .challenge-category {
            font-size: 0.75rem;
            color: #666;
            margin-bottom: 8px;
        }
        .challenge-hint {
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 16px;
            padding: 10px 14px;
            background: #0d0d0d;
            border-left: 3px solid #00cc33;
            border-radius: 0 4px 4px 0;
        }
        .flag-form {
            display: flex;
            gap: 10px;
        }
        .flag-form input {
            flex: 1;
            padding: 10px 14px;
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 4px;
            color: #00ff41;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
        .flag-form input:focus {
            outline: none;
            border-color: #00ff41;
            box-shadow: 0 0 5px rgba(0, 255, 65, 0.3);
        }
        .flag-form button {
            padding: 10px 20px;
            background: #00ff41;
            color: #000;
            border: none;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            white-space: nowrap;
        }
        .flag-form button:hover {
            background: #00cc33;
            box-shadow: 0 0 10px rgba(0, 255, 65, 0.5);
        }
        .solved-badge {
            display: inline-block;
            color: #00ff41;
            font-size: 0.85rem;
            margin-top: 10px;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-success {
            background: rgba(0, 255, 65, 0.1);
            border: 1px solid #00ff41;
            color: #00ff41;
        }
        .alert-error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff4444;
            color: #ff4444;
        }
        .alert-warning {
            background: rgba(255, 165, 0, 0.1);
            border: 1px solid #ffa500;
            color: #ffa500;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            color: #666;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .back-link:hover { color: #00ff41; }
    </style>
</head>
<body>
    <div class="container">
        <h1>&#x1f3f4; CTF Judge</h1>
        <p class="subtitle">Submeta suas flags para validação</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="challenges-grid">
            @foreach($challenges as $challenge)
                @php
                    $solved = \App\Models\Submission::where('user_id', auth()->id())
                        ->where('challenge_id', $challenge->id)
                        ->where('is_correct', true)
                        ->exists();
                @endphp
                <div class="challenge-card {{ $solved ? 'solved' : '' }}">
                    <div class="challenge-header">
                        <span class="challenge-title">{{ $challenge->title }}</span>
                        <span class="challenge-points">{{ $challenge->points }} pts</span>
                    </div>
                    <div class="challenge-category">{{ $challenge->category }}</div>
                    <div class="challenge-hint"> {{ $challenge->description }}</div>

                    @if($solved)
                        <span class="solved-badge">✅ Resolvido</span>
                    @else
                        <form method="POST" action="{{ route('judge.submit') }}" class="flag-form">
                            @csrf
                            <input type="hidden" name="challenge_id" value="{{ $challenge->id }}">
                            <input type="text" name="flag" placeholder="FLAG{...}" required autocomplete="off">
                            <button type="submit">SUBMETER</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <a href="{{ route('dashboard') }}" class="back-link">&larr; Voltar ao Dashboard</a>
    </div>
</body>
</html>
