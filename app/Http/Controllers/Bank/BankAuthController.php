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
            session(['bank_user_id' => $user->id]);
            return redirect()->route('bank.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
    }

    public function logout()
    {
        session()->forget('bank_user_id');
        return redirect()->route('bank.login');
    }
}
