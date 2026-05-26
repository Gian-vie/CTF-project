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
                'title' => 'Default Credentials',
                'description' => 'O banco possui uma conta administrativa com credenciais padrão. Encontre e acesse essa conta.',
                'flag' => 'FLAG{default_creds_admin123_pwned}',
                'points' => 100,
                'category' => 'Authentication',
            ],
            [
                'title' => 'Info Disclosure',
                'description' => 'Desenvolvedores às vezes deixam informações sensíveis no código-fonte das páginas. Inspecione com atenção.',
                'flag' => 'FLAG{html_source_hidden_comment_4d3f}',
                'points' => 50,
                'category' => 'Information Disclosure',
            ],
            [
                'title' => 'IDOR - Insecure Direct Object Reference',
                'description' => 'O sistema não valida corretamente a propriedade dos recursos. Tente acessar dados de outro correntista.',
                'flag' => 'FLAG{idor_account_access_broken_a7c2}',
                'points' => 150,
                'category' => 'Broken Access Control',
            ],
            [
                'title' => 'Cross-Site Scripting (XSS)',
                'description' => 'Alguns campos do sistema não sanitizam a entrada do usuário. Injete código e descubra o que está escondido.',
                'flag' => 'FLAG{xss_reflected_no_sanitize_9f1b}',
                'points' => 200,
                'category' => 'XSS',
            ],
            [
                'title' => 'SQL Injection',
                'description' => 'O backend usa queries inseguras. Explore a injeção para extrair dados ocultos do banco.',
                'flag' => 'FLAG{sqli_raw_query_exposed_e5d8}',
                'points' => 250,
                'category' => 'Injection',
            ],
            [
                'title' => 'Broken Access Control - Caixinha',
                'description' => 'O sistema de resgate da caixinha não valida a propriedade corretamente. Roube de outra conta.',
                'flag' => 'FLAG{broken_access_caixinha_steal_b3a1}',
                'points' => 200,
                'category' => 'Broken Access Control',
            ],
            [
                'title' => 'Interceptação de Código de Verificação',
                'description' => 'O sistema de troca de senha envia um código de verificação. Será que ele está realmente seguro no transporte?',
                'flag' => 'FLAG{intercepted_verification_code_7e2a}',
                'points' => 150,
                'category' => 'Information Disclosure',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }
    }
}
