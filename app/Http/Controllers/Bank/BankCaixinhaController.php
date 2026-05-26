<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankUser;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BankCaixinhaController extends Controller
{
    public function index()
    {
        $user = BankUser::find(session('bank_user_id'));
        $account = $user->accounts()->first();
        $caixinha = $account->caixinha;

        // Histórico de operações da caixinha (depósitos/resgates)
        $history = Transaction::where('bank_account_id', $account->id)
            ->whereIn('type', ['deposito'])
            ->latest()
            ->limit(10)
            ->get();

        return view('bank.caixinha', compact('account', 'caixinha', 'history'));
    }

    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $user = BankUser::find(session('bank_user_id'));
        $account = $user->accounts()->first();
        $caixinha = $account->caixinha;

        $amount = (float) $request->amount;

        if ($amount > $account->balance) {
            return back()->withErrors(['amount' => 'Saldo insuficiente na conta.']);
        }

        $account->decrement('balance', $amount);
        $caixinha->increment('balance', $amount);

        Transaction::create([
            'bank_account_id' => $account->id,
            'type' => 'deposito',
            'description' => 'Depósito na Caixinha',
            'amount' => -$amount,
        ]);

        return back()->with('success', 'Depósito realizado!');
    }

    public function withdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $user = BankUser::find(session('bank_user_id'));
        $account = $user->accounts()->first();
        $caixinha = $account->caixinha;

        if (!$caixinha) {
            return back()->withErrors(['amount' => 'Caixinha não encontrada.']);
        }

        $amount = (float) $request->amount;

        if ($amount > $caixinha->balance) {
            return back()->withErrors(['amount' => 'Saldo insuficiente na caixinha.']);
        }

        $caixinha->decrement('balance', $amount);
        $account->increment('balance', $amount);

        Transaction::create([
            'bank_account_id' => $account->id,
            'type' => 'deposito',
            'description' => 'Resgate da Caixinha',
            'amount' => $amount,
        ]);

        return back()->with('success', 'Resgate realizado!');
    }
}
