<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\BankUser;
use App\Models\Caixinha;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BankSeeder extends Seeder
{
    public function run()
    {
        // === Correntista 1: João (usuário padrão, senha fraca) ===
        $joao = BankUser::create([
            'name' => 'João Demo da Silva',
            'email' => 'joao.demo@email.com',
            'password' => Hash::make('123456'),
            'cpf' => '123.456.789-42',
            'phone' => '(11) 99999-0000',
        ]);

        $contaJoao = BankAccount::create([
            'bank_user_id' => $joao->id,
            'account_number' => '00047842-5',
            'agency' => '0001',
            'balance' => 12450.00,
            'type' => 'corrente',
        ]);

        // Transações do João
        Transaction::insert([
            [
                'bank_account_id' => $contaJoao->id,
                'type' => 'pix',
                'description' => 'PIX - Maria Silva',
                'amount' => -150.00,
                'created_at' => '2026-05-22 14:30:00',
                'updated_at' => '2026-05-22 14:30:00',
            ],
            [
                'bank_account_id' => $contaJoao->id,
                'type' => 'salario',
                'description' => 'Salário - Empresa XYZ',
                'amount' => 5400.00,
                'created_at' => '2026-05-20 08:00:00',
                'updated_at' => '2026-05-20 08:00:00',
            ],
            [
                'bank_account_id' => $contaJoao->id,
                'type' => 'pagamento',
                'description' => 'Fatura Cartão Crédito',
                'amount' => -2890.50,
                'created_at' => '2026-05-15 10:00:00',
                'updated_at' => '2026-05-15 10:00:00',
            ],
            [
                'bank_account_id' => $contaJoao->id,
                'type' => 'ted',
                'description' => 'TED - Aluguel',
                'amount' => -1800.00,
                'created_at' => '2026-05-10 09:00:00',
                'updated_at' => '2026-05-10 09:00:00',
            ],
            [
                'bank_account_id' => $contaJoao->id,
                'type' => 'deposito',
                'description' => 'Depósito na Caixinha',
                'amount' => -500.00,
                'created_at' => '2026-05-15 11:00:00',
                'updated_at' => '2026-05-15 11:00:00',
            ],
        ]);

        // Caixinha do João
        Caixinha::create([
            'bank_account_id' => $contaJoao->id,
            'balance' => 3200.00,
            'total_yield' => 84.20,
        ]);

        // === Correntista 2: Maria (para IDOR — dados que o atacante pode ver) ===
        $maria = BankUser::create([
            'name' => 'Maria Oliveira Santos',
            'email' => 'maria.oliveira@email.com',
            'password' => Hash::make('maria2024'),
            'cpf' => '987.654.321-00',
            'phone' => '(21) 98888-1111',
        ]);

        $contaMaria = BankAccount::create([
            'bank_user_id' => $maria->id,
            'account_number' => '00098321-7',
            'agency' => '0001',
            'balance' => 45780.00,
            'type' => 'corrente',
        ]);

        Transaction::insert([
            [
                'bank_account_id' => $contaMaria->id,
                'type' => 'salario',
                'description' => 'Salário - Corp ABC',
                'amount' => 12000.00,
                'created_at' => '2026-05-20 08:00:00',
                'updated_at' => '2026-05-20 08:00:00',
            ],
            [
                'bank_account_id' => $contaMaria->id,
                'type' => 'pix',
                'description' => 'PIX - Loja Premium',
                'amount' => -3200.00,
                'created_at' => '2026-05-18 16:45:00',
                'updated_at' => '2026-05-18 16:45:00',
            ],
        ]);

        Caixinha::create([
            'bank_account_id' => $contaMaria->id,
            'balance' => 15000.00,
            'total_yield' => 420.50,
        ]);

        // === Correntista 3: Admin (credenciais padrão — vuln Default Creds) ===
        $admin = BankUser::create([
            'name' => 'Administrador DAADS',
            'email' => 'admin@daads.com',
            'password' => Hash::make('admin123'),
            'cpf' => '000.000.000-00',
            'phone' => '(11) 3000-0000',
        ]);

        $contaAdmin = BankAccount::create([
            'bank_user_id' => $admin->id,
            'account_number' => '00000001-0',
            'agency' => '0001',
            'balance' => 999999.99,
            'type' => 'corrente',
        ]);

        Transaction::insert([
            [
                'bank_account_id' => $contaAdmin->id,
                'type' => 'deposito',
                'description' => 'Aporte Inicial - Sistema',
                'amount' => 999999.99,
                'created_at' => '2026-01-01 00:00:00',
                'updated_at' => '2026-01-01 00:00:00',
            ],
        ]);

        // === Tabela de segredos (flag SQLi) ===
        // A flag está codificada em base64 no campo password
        \DB::table('bank_secrets')->insert([
            'key' => 'admin_flag',
            'secret' => 'Acesso restrito - consulte o administrador',
            'password' => base64_encode('FLAG{sqli_raw_query_exposed_e5d8}'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
