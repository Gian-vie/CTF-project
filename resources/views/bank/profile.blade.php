@extends('bank.layout')
@section('title', 'Perfil')
@section('nav-profile', 'active')

@section('content')
    <div class="page-header">
        <h2>Meu Perfil</h2>
        <p>Gerencie suas informações pessoais</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="panel">
            <h3>Informações Pessoais</h3>
            <form>
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" value="João Demo da Silva">
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" value="***.***.***-42" disabled>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" value="joao.demo@email.com">
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" value="(11) 99999-0000">
                </div>
                <button type="button" class="btn-purple">Salvar Alterações</button>
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
                        <td>0001</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Conta</td>
                        <td>00047842-5</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Tipo</td>
                        <td>Conta Corrente</td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted);">Desde</td>
                        <td>Março/2024</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
