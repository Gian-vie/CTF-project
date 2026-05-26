@extends('bank.layout')
@section('title', 'Perfil')
@section('nav-profile', 'active')

@section('content')
    <!-- FLAG{html_source_hidden_comment_4d3f} -->
    <div class="page-header">
        <h2>Meu Perfil</h2>
        <p>Gerencie suas informações pessoais</p>
    </div>

    @if (session('success'))
        <div style="background: rgba(0,200,83,0.1); border: 1px solid rgba(0,200,83,0.3); color: #00c853; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: rgba(255,82,82,0.1); border: 1px solid rgba(255,82,82,0.3); color: #ff5252; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="panel">
            <h3>Informações Pessoais</h3>
            {{-- VULNERABILIDADE: XSS — nome renderizado sem escape --}}
            <p style="color: var(--neon-purple); margin-bottom: 1rem;">Olá, {!! $user->name !!}</p>
            {{-- FLAG 4: XSS — div oculta que o participante revela via XSS --}}
            <div id="flag-xss" style="display: none; font-family: monospace; color: #00c853; margin-bottom: 1rem;">FLAG{xss_reflected_no_sanitize_9f1b}</div>
            <form method="POST" action="{{ route('bank.profile.update') }}">
                @csrf
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" value="{{ substr($user->cpf, 0, 3) }}.***.***-{{ substr($user->cpf, -2) }}" disabled>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}">
                </div>
                <button type="submit" class="btn-purple">Salvar Alterações</button>
            </form>
        </div>

        <div class="panel">
            <h3>Segurança</h3>
            <form>
                <div class="form-group">
                    <label>Senha Atual</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label>Nova Senha</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label>Confirmar Nova Senha</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <button type="button" class="btn-purple">Alterar Senha</button>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--dark-border);">
                <h3>Dados da Conta</h3>
                <table>
                    <tr>
                        <td style="color: var(--text-muted);">Agência</td>
                        <td>{{ $account->agency }}</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Conta</td>
                        <td>{{ $account->account_number }}</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Tipo</td>
                        <td>Conta {{ ucfirst($account->type) }}</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Desde</td>
                        <td>{{ $account->created_at->translatedFormat('F/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
