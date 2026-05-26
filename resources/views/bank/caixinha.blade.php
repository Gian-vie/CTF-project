@extends('bank.layout')
@section('title', 'Caixinha')
@section('nav-caixinha', 'active')

@section('content')
    <style>
        .tx-negative { color: #ff5252; }
        .tx-positive  { color: #00c853; }
    </style>
    <div class="page-header">
        <h2>Caixinha</h2>
        <p>Guarde dinheiro e veja seu saldo render automaticamente</p>
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

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Saldo na Caixinha</div>
            <div class="card-value purple">R$ {{ $caixinha ? number_format($caixinha->balance, 2, ',', '.') : '0,00' }}</div>
            <div class="card-sub">Rendimento: 102% do CDI</div>
        </div>
        <div class="card">
            <div class="card-label">Rendimento Total</div>
            <div class="card-value">R$ {{ $caixinha ? number_format($caixinha->total_yield, 2, ',', '.') : '0,00' }}</div>
            <div class="card-sub">Desde o primeiro depósito</div>
        </div>
        <div class="card">
            <div class="card-label">Saldo Conta Corrente</div>
            <div class="card-value">R$ {{ number_format($account->balance, 2, ',', '.') }}</div>
            <div class="card-sub">Disponível para depósito</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="panel">
            <h3>Depositar na Caixinha</h3>
            <form method="POST" action="{{ route('bank.caixinha.deposit') }}">
                @csrf
                <div class="form-group">
                    <label>Valor do Depósito</label>
                    <input type="number" step="0.01" name="amount" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Origem</label>
                    <input type="text" value="Conta {{ ucfirst($account->type) }} • ****{{ substr($account->account_number, -4) }}" disabled>
                </div>
                <button type="submit" class="btn-purple">Depositar</button>
            </form>
        </div>

        <div class="panel">
            <h3>Resgatar da Caixinha</h3>
            <form method="POST" action="{{ route('bank.caixinha.withdraw') }}">
                @csrf
                {{-- VULNERABILIDADE: campo hidden caixinha_id manipulável --}}
                <input type="hidden" name="caixinha_id" value="{{ $caixinha ? $caixinha->id : '' }}">
                <div class="form-group">
                    <label>Valor do Resgate</label>
                    <input type="number" step="0.01" name="amount" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Destino</label>
                    <input type="text" value="Conta {{ ucfirst($account->type) }} • ****{{ substr($account->account_number, -4) }}" disabled>
                </div>
                <button type="submit" class="btn-purple">Resgatar</button>
            </form>
        </div>
    </div>

    <div class="panel" style="margin-top: 1.5rem;">
        <h3>Histórico da Caixinha</h3>
        <table>
            <thead>
                <tr>
                    <th>Operação</th>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($history as $tx)
                <tr>
                    <td><span class="badge badge-success">{{ $tx->description }}</span></td>
                    <td>{{ $tx->created_at->format('d/m/Y') }}</td>
                    <td class="{{ $tx->amount < 0 ? 'tx-negative' : 'tx-positive' }}">
                        {{ $tx->amount < 0 ? '-' : '+' }} R$ {{ number_format(abs($tx->amount), 2, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center; color: var(--text-muted);">Nenhuma operação encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
