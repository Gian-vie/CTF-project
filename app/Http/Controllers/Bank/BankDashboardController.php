<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankUser;

class BankDashboardController extends Controller
{
    public function index()
    {
        // VULNERABILIDADE: IDOR — aceita ?account_id=X para ver conta alheia
        $accountId = request('account_id');

        if ($accountId) {
            $account = BankAccount::with(['user', 'transactions', 'caixinha'])->find($accountId);
        } else {
            $user = BankUser::find(session('bank_user_id'));
            $account = $user->accounts()->with(['transactions', 'caixinha'])->first();
        }

        if (!$account) {
            return redirect()->route('bank.login');
        }

        $transactions = $account->transactions()->latest()->limit(5)->get();
        $caixinha = $account->caixinha;

        return view('bank.dashboard', compact('account', 'transactions', 'caixinha'));
    }
}
