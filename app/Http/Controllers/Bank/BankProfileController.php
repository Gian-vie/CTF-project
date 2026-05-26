<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankProfileController extends Controller
{
    public function index()
    {
        $user = BankUser::find(session('bank_user_id'));
        $account = $user->accounts()->first();

        return view('bank.profile', compact('user', 'account'));
    }

    public function update(Request $request)
    {
        $user = BankUser::find(session('bank_user_id'));

        // VULNERABILIDADE: SQL Injection — campo nome sem sanitização
        // Usa query raw propositalmente para permitir SQLi
        DB::statement("UPDATE bank_users SET name = '{$request->name}' WHERE id = {$user->id}");

        // VULNERABILIDADE: XSS — nome salvo sem escapar, será renderizado sem htmlspecialchars
        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
