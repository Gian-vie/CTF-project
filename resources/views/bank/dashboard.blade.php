@extends('bank.layout')
@section('title', 'Dashboard')
@section('nav-dashboard', 'active')

@section('content')
    <!-- FLAG{html_source_hidden_comment_4d3f} -->

    {{-- FLAG 3: IDOR — aparece quando acessando conta de outro usuário --}}
    @if (request('account_id') && $account->bank_user_id != session('bank_user_id'))
        <div style="background: rgba(255,82,82,0.1); border: 1px solid rgba(255,82,82,0.3); padding: 1rem 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <strong style="color: #ff5252;">⚠️ Nota Interna (Confidencial)</strong>
            <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.85rem;">Este registro pertence a outro correntista. Acesso não autorizado detectado.</p>
            <div style="margin-top: 0.5rem; font-family: monospace; color: #00c853;">FLAG{idor_account_access_broken_a7c2}</div>
        </div>
    @endif

    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Bem-vindo de volta, {{ $account->user->name }}. Aqui está o resumo da sua conta.</p>
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Saldo Disponível</div>
            <div class="card-value purple">R$ {{ number_format($account->balance, 2, ',', '.') }}</div>
            <div class="card-sub">Conta {{ ucfirst($account->type) }} • ****{{ substr($account->account_number, -4) }}</div>
        </div>
        <div class="card">
            <div class="card-label">Caixinha</div>
            <div class="card-value">R$ {{ $caixinha ? number_format($caixinha->balance, 2, ',', '.') : '0,00' }}</div>
            <div class="card-sub">Rendimento: +R$ {{ $caixinha ? number_format($caixinha->total_yield, 2, ',', '.') : '0,00' }}</div>
        </div>
        <div class="card">
            <div class="card-label">Cartão de Crédito</div>
            <div class="card-value">R$ 2.890,50</div>
            <div class="card-sub">Fatura atual • Venc. 15/06</div>
        </div>
    </div>

    <div class="panel">
        <h3>Últimas Transações</h3>
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $tx)
                <tr>
                    <td>{{ $tx->description }}</td>
                    <td>{{ $tx->created_at->format('d/m/Y') }}</td>
                    <td style="color: {{ $tx->amount < 0 ? '#ff5252' : '#00c853' }};">
                        {{ $tx->amount < 0 ? '-' : '+' }} R$ {{ number_format(abs($tx->amount), 2, ',', '.') }}
                    </td>
                    <td><span class="badge badge-success">Concluído</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color: var(--text-muted);">Nenhuma transação encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
