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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            width: 100%;
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
            margin-bottom: 30px;
        }
        .card {
            background: #111;
            border: 1px solid #00ff41;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.9rem;
            color: #00cc33;
        }
        input, select {
            width: 100%;
            padding: 12px;
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 4px;
            color: #00ff41;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #00ff41;
            box-shadow: 0 0 5px rgba(0, 255, 65, 0.3);
        }
        select option {
            background: #1a1a1a;
            color: #00ff41;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: #00ff41;
            color: #000;
            border: none;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
        }
        .btn:hover {
            background: #00cc33;
            box-shadow: 0 0 15px rgba(0, 255, 65, 0.5);
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
        .challenge-info {
            font-size: 0.8rem;
            color: #666;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>&#x1f3f4; CTF Judge</h1>
        <p class="subtitle">Submeta sua flag para validação</p>

        <div class="card">
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

            <form method="POST" action="{{ route('judge.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="challenge_id">Desafio</label>
                    <select id="challenge_id" name="challenge_id" required>
                        <option value="">Selecione o desafio...</option>
                        @foreach($challenges as $challenge)
                            <option value="{{ $challenge->id }}" {{ old('challenge_id') == $challenge->id ? 'selected' : '' }}>
                                {{ $challenge->title }} ({{ $challenge->points }}pts) - {{ $challenge->category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="flag">Flag</label>
                    <input type="text" id="flag" name="flag" placeholder="CTF{sua_flag_aqui}" required autocomplete="off">
                </div>

                <button type="submit" class="btn">SUBMETER FLAG</button>
            </form>
        </div>
    </div>
</body>
</html>
