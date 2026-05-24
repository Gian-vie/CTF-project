@extends('bank.layout')
@section('title', 'Caixinha')
@section('nav-caixinha', 'active')

@section('content')
    <div class="page-header">
        <h2>Caixinha</h2>
        <p>Guarde dinheiro e veja seu saldo render automaticamente</p>
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Saldo na Caixinha</div>
            <div class="card-value purple">R$ 3.200,00</div>
            <div class="card-sub">Rendimento: 102% do CDI</div>
        </div>
        <div class="card">
            <div class="card-label">Rendimento Total</div>
            <div class="card-value">R$ 84,20</div>
            <div class="card-sub">Desde o primeiro depósito</div>
        </div>
        <div class="card">
            <div class="card-label">Rendimento Mensal</div>
            <div class="card-value">R$ 18,40</div>
            <div class="card-sub">Maio/2026</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="panel">
            <h3>Depositar na Caixinha</h3>
            <form>
                <div class="form-group">
                    <label>Valor do Depósito</label>
                    <input type="text" placeholder="R$ 0,00">
                </div>
                <div class="form-group">
                    <label>Origem</label>
                    <input type="text" value="Conta Corrente • ****7842" disabled>
                </div>
                <button type="button" class="btn-purple">Depositar</button>
            </form>
        </div>

        <div class="panel">
            <h3>Resgatar da Caixinha</h3>
            <form>
                <div class="form-group">
                    <label>Valor do Resgate</label>
                    <input type="text" placeholder="R$ 0,00">
                </div>
                <div class="form-group">
                    <label>Destino</label>
                    <input type="text" value="Conta Corrente • ****7842" disabled>
                </div>
                <button type="button" class="btn-purple">Resgatar</button>
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
                    <th>Saldo Após</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="badge badge-success">Depósito</span></td>
                    <td>15/05/2026</td>
                    <td style="color: #00c853;">+ R$ 500,00</td>
                    <td>R$ 3.200,00</td>
                </tr>
                <tr>
                    <td><span class="badge badge-pending">Rendimento</span></td>
                    <td>01/05/2026</td>
                    <td style="color: #00c853;">+ R$ 18,40</td>
                    <td>R$ 2.700,00</td>
                </tr>
                <tr>
                    <td><span class="badge badge-success">Depósito</span></td>
                    <td>10/04/2026</td>
                    <td style="color: #00c853;">+ R$ 1.000,00</td>
                    <td>R$ 2.681,60</td>
                </tr>
                <tr>
                    <td><span class="badge badge-success">Depósito</span></td>
                    <td>01/03/2026</td>
                    <td style="color: #00c853;">+ R$ 1.500,00</td>
                    <td>R$ 1.681,60</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
