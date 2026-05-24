@extends('bank.layout')
@section('title', 'Dashboard')
@section('nav-dashboard', 'active')

@section('content')
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Bem-vindo de volta, João. Aqui está o resumo da sua conta.</p>
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Saldo Disponível</div>
            <div class="card-value purple">R$ 12.450,00</div>
            <div class="card-sub">Conta Corrente • ****7842</div>
        </div>
        <div class="card">
            <div class="card-label">Caixinha</div>
            <div class="card-value">R$ 3.200,00</div>
            <div class="card-sub">Rendimento: +R$ 18,40 este mês</div>
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
                <tr>
                    <td>PIX - Maria Silva</td>
                    <td>22/05/2026</td>
                    <td style="color: #ff5252;">- R$ 150,00</td>
                    <td><span class="badge badge-success">Concluído</span></td>
                </tr>
                <tr>
                    <td>Salário - Empresa XYZ</td>
                    <td>20/05/2026</td>
                    <td style="color: #00c853;">+ R$ 5.400,00</td>
                    <td><span class="badge badge-success">Concluído</span></td>
                </tr>
                <tr>
                    <td>Netflix</td>
                    <td>18/05/2026</td>
                    <td style="color: #ff5252;">- R$ 55,90</td>
                    <td><span class="badge badge-success">Concluído</span></td>
                </tr>
                <tr>
                    <td>Transferência - Caixinha</td>
                    <td>15/05/2026</td>
                    <td style="color: #ff5252;">- R$ 500,00</td>
                    <td><span class="badge badge-pending">Processando</span></td>
                </tr>
                <tr>
                    <td>Supermercado BomPreço</td>
                    <td>14/05/2026</td>
                    <td style="color: #ff5252;">- R$ 287,30</td>
                    <td><span class="badge badge-success">Concluído</span></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
