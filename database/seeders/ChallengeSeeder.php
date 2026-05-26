<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run()
    {
        $challenges = [
            [
                'title' => 'Info Disclosure',
                'description' => 'Desenvolvedores às vezes deixam informações sensíveis no código-fonte das páginas. Inspecione com atenção.',
                'flag' => 'FLAG{html_source_hidden_comment_4d3f}',
                'points' => 50,
                'category' => 'Information Disclosure',
            ],
            [
                'title' => 'Interceptação de Código de Verificação',
                'description' => 'O sistema de troca de senha envia um código de verificação. Será que ele está realmente seguro no transporte?',
                'flag' => 'FLAG{intercepted_verification_code_7e2a}',
                'points' => 150,
                'category' => 'Information Disclosure',
            ],
            [
                'title' => 'SQL Injection',
                'description' => 'O backend usa queries inseguras. Explore a injeção para extrair dados ocultos do banco.',
                'flag' => 'FLAG{sqli_raw_query_exposed_e5d8}',
                'points' => 250,
                'category' => 'Injection',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }
    }
}
