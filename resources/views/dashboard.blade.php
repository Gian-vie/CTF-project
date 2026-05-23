<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submeter Flags') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-lg sm:rounded-lg border border-green-500/30">
                <div class="p-8 text-green-400 font-mono">
                    <h3 class="text-2xl font-bold text-green-300 mb-4">&#x1f3af; Operação Vault Breaker</h3>

                    <div class="space-y-4 text-sm leading-relaxed">
                        <p class="text-green-200">
                            Agente, você foi convocado para a missão mais crítica da temporada.
                        </p>
                        <p>
                            O <span class="text-white font-bold">DAADS Bank</span> — uma das instituições financeiras mais seguras do mundo digital — esconde segredos em seus sistemas. Nossos analistas detectaram vulnerabilidades que podem ser exploradas, mas o tempo é limitado.
                        </p>
                        <p>
                            Sua missão: infiltrar os sistemas do banco, encontrar as flags escondidas nas brechas de segurança e submetê-las aqui para provar que a invasão foi bem-sucedida.
                        </p>
                        <p class="text-yellow-400 font-semibold">
                            ⚠️ Cada flag encontrada comprova uma vulnerabilidade real. Quanto mais rápido você agir, mais pontos acumula para o seu time.
                        </p>
                        <p class="text-green-200">
                            Boa sorte, agente. O relógio está correndo.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="http://localhost:8081" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg shadow-green-900/50 hover:shadow-green-800/70">
                            &#x1f310; Acessar DAADS Bank
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        <a href="{{ route('judge') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-700 hover:bg-gray-600 text-green-400 font-bold rounded-lg transition-all duration-200 border border-green-500/50">
                            &#x1f3f4; Submeter Flag
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
