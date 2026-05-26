<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankUser;

class BankDashboardController extends Controller
{
    public function index()
    {
        $user = BankUser::find(session('bank_user_id'));
        $account = $user->accounts()->with(['transactions', 'caixinha'])->first();

        if (!$account) {
            return redirect()->route('bank.login');
        }

        $transactions = $account->transactions()->latest()->limit(5)->get();
        $caixinha = $account->caixinha;

        return view('bank.dashboard', compact('account', 'transactions', 'caixinha'));
    }
}
