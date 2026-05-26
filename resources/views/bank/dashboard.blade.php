@extends('bank.layout')
@section('title', 'Dashboard')
@section('nav-dashboard', 'active')

@section('content')
<!-- FLAG{html_source_hidden_comment_4d3f} -->

<style>
    .tx-negative { color: #ff5252; }
    .tx-positive  { color: #00c853; }
</style>

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
                <td class="{{ $tx->amount < 0 ? 'tx-negative' : 'tx-positive' }}">
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