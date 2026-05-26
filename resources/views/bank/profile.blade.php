@extends('bank.layout')
@section('title', 'Perfil')
@section('nav-profile', 'active')

@section('content')
    <!-- hint: ROT13 → ', anzr=(FRYRPG cnffjbeq SEBZ onax_frpergf JURER vq=1) JURER vq=1 # -->
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
            <p style="color: var(--neon-purple); margin-bottom: 1rem;">Olá, {{ $user->name }}</p>
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

            {{-- Encerrar conta --}}
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--dark-border);">
                @if (session('delete_error'))
                    <div style="background: rgba(255,82,82,0.1); border: 1px solid rgba(255,82,82,0.3); color: #ff5252; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        {{ session('delete_error') }}
                    </div>
                @endif
                <button type="button" onclick="document.getElementById('delete-modal').style.display='flex'" style="background: none; border: 1px solid #ff5252; color: #ff5252; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem;">
                    Encerrar Conta
                </button>
            </div>
        </div>

        <div class="panel">
            <h3>Segurança</h3>

            @if (session('password_success'))
                <div style="background: rgba(0,200,83,0.1); border: 1px solid rgba(0,200,83,0.3); color: #00c853; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('password_success') }}
                </div>
            @endif

            @if (session('password_error'))
                <div style="background: rgba(255,82,82,0.1); border: 1px solid rgba(255,82,82,0.3); color: #ff5252; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('password_error') }}
                </div>
            @endif

            {{-- Etapa 1: Solicitar código --}}
            @if (!session('bank_password_code_sent'))
            <form method="POST" action="{{ route('bank.profile.password.request') }}">
                @csrf
                <div class="form-group">
                    <label>Senha Atual</label>
                    <input type="password" name="current_password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label>Nova Senha</label>
                    <input type="password" name="new_password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Nova Senha</label>
                    <input type="password" name="new_password_confirmation" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-purple">Solicitar Código de Verificação</button>
            </form>
            @else
            {{-- Etapa 2: Confirmar código --}}
            <p style="color: var(--text-muted); margin-bottom: 1rem; font-size: 0.9rem;">Um código de 6 dígitos foi enviado para seu e-mail. Insira abaixo para confirmar.</p>
            <div id="timer"
                data-expires-at="{{ session('bank_password_expires_at', 0) }}"
                data-sent-at="{{ session('bank_password_code_sent_at', 0) }}"
                data-profile-url="{{ route('bank.profile') }}"
                style="color: var(--neon-purple); font-size: 0.9rem; margin-bottom: 1rem; font-family: monospace;">Tempo restante: <span id="countdown">05:00</span></div>
            <form method="POST" action="{{ route('bank.profile.password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label>Código de Verificação</label>
                    <input type="text" name="code" placeholder="000000" maxlength="6" required id="code-input">
                </div>
                <button type="submit" class="btn-purple" id="btn-confirm">Confirmar Alteração</button>
            </form>

            {{-- Reencaminhar código (liberado após 30s) --}}
            <form method="POST" action="{{ route('bank.profile.password.resend') }}" style="margin-top: 1rem;">
                @csrf
                <button type="submit" class="btn-purple" id="btn-resend" disabled style="opacity: 0.5; font-size: 0.85rem;">Reenviar código (<span id="resend-timer">30</span>s)</button>
            </form>

            {{-- Cancelar --}}
            <form method="POST" action="{{ route('bank.profile.password.cancel') }}" style="margin-top: 0.75rem;">
                @csrf
                <button type="submit" style="background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: 0.85rem; text-decoration: underline;">Cancelar</button>
            </form>

            <script>
                // Timer de 5 minutos
                (function() {
                    const timerEl = document.getElementById('timer');
                    const expiresAt = parseInt(timerEl.dataset.expiresAt, 10) * 1000;
                    const sentAt   = parseInt(timerEl.dataset.sentAt,    10) * 1000;
                    const profileUrl = timerEl.dataset.profileUrl;
                    const countdownEl = document.getElementById('countdown');
                    const codeInput = document.getElementById('code-input');
                    const btnConfirm = document.getElementById('btn-confirm');

                    function updateTimer() {
                        const now = Date.now();
                        const remaining = Math.max(0, expiresAt - now);
                        const minutes = Math.floor(remaining / 60000);
                        const seconds = Math.floor((remaining % 60000) / 1000);
                        countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

                        if (remaining <= 0) {
                            countdownEl.textContent = '00:00';
                            countdownEl.style.color = '#ff5252';
                            codeInput.disabled = true;
                            btnConfirm.disabled = true;
                            btnConfirm.style.opacity = '0.5';
                            // Redireciona após 2s
                            setTimeout(function() { window.location.href = timerEl.dataset.profileUrl; }, 2000);
                            return;
                        }
                        setTimeout(updateTimer, 1000);
                    }
                    updateTimer();

                    // Resend timer de 30s
                    const btnResend = document.getElementById('btn-resend');
                    const resendTimerEl = document.getElementById('resend-timer');

                    function updateResend() {
                        const elapsed = Math.floor((Date.now() - sentAt) / 1000);
                        const remaining = Math.max(0, 30 - elapsed);
                        resendTimerEl.textContent = remaining;

                        if (remaining <= 0) {
                            btnResend.disabled = false;
                            btnResend.style.opacity = '1';
                            btnResend.innerHTML = 'Reenviar código';
                            return;
                        }
                        setTimeout(updateResend, 1000);
                    }
                    updateResend();
                })();
            </script>
            @endif

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

    {{-- Modal de confirmação de exclusão --}}
    <div id="delete-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); align-items:center; justify-content:center; z-index:9999;">
        <div style="background: var(--dark-card); border: 1px solid var(--dark-border); border-radius: 1rem; padding: 2rem; max-width: 420px; width: 90%; text-align: center;">
            <h3 style="color: #ff5252; margin-bottom: 1rem;">Encerrar Conta</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem;">
                Tem certeza que deseja encerrar sua conta? Sua conta será desativada e você não poderá acessá-la até reativá-la.
            </p>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.85rem;">
                <strong style="color: #ff5252;">Atenção:</strong> Para encerrar, o saldo em conta e na caixinha devem estar zerados.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button onclick="document.getElementById('delete-modal').style.display='none'" style="background: var(--dark-bg); border: 1px solid var(--dark-border); color: var(--text-muted); padding: 0.6rem 1.2rem; border-radius: 0.5rem; cursor: pointer;">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('bank.profile.delete') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #ff5252; border: none; color: white; padding: 0.6rem 1.2rem; border-radius: 0.5rem; cursor: pointer; font-weight: bold;">
                        Confirmar Encerramento
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
