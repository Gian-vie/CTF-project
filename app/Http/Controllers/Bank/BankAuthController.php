<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BankAuthController extends Controller
{
    public function showLogin()
    {
        return view('bank.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = BankUser::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Conta deletada — redirecionar para tela de reativação
            if ($user->deleted_at) {
                session(['bank_deleted_user_id' => $user->id]);
                return redirect()->route('bank.deleted');
            }

            session()->regenerate();
            session(['bank_user_id' => $user->id]);
            return redirect()->route('bank.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
    }

    public function showDeleted()
    {
        if (!session('bank_deleted_user_id')) {
            return redirect()->route('bank.login');
        }
        return view('bank.deleted');
    }

    public function reactivate()
    {
        $userId = session('bank_deleted_user_id');
        if (!$userId) {
            return redirect()->route('bank.login');
        }

        $user = BankUser::find($userId);
        $user->deleted_at = null;
        $user->save();

        session()->forget('bank_deleted_user_id');
        session(['bank_user_id' => $user->id]);

        return redirect()->route('bank.dashboard');
    }

    public function permanentDelete()
    {
        $userId = session('bank_deleted_user_id');
        if (!$userId) {
            return redirect()->route('bank.login');
        }

        $user = BankUser::find($userId);

        // Deletar dados relacionados permanentemente
        foreach ($user->accounts as $account) {
            $account->transactions()->delete();
            if ($account->caixinha) {
                $account->caixinha->delete();
            }
            $account->delete();
        }
        $user->delete();

        session()->forget('bank_deleted_user_id');

        return redirect()->route('bank.login')->with('message', 'Conta deletada permanentemente.');
    }

    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('bank.login');
    }
}
