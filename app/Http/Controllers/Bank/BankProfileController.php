<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::unprepared("UPDATE bank_users SET name = '{$request->name}' WHERE id = {$user->id}");

        // VULNERABILIDADE: XSS — nome salvo sem escapar, será renderizado sem htmlspecialchars
        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function passwordRequest(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed',
        ]);

        $user = BankUser::find(session('bank_user_id'));

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Senha atual incorreta.');
        }

        // Gera código de 6 dígitos
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Salva na sessão com timestamps
        session([
            'bank_password_code' => $code,
            'bank_password_code_sent' => true,
            'bank_password_code_sent_at' => time(),
            'bank_password_expires_at' => time() + 300, // 5 minutos
            'bank_new_password' => $request->new_password,
        ]);

        // VULNERABILIDADE: código exposto no response header — interceptável
        return back()
            ->header('X-Verification-Code', $code)
            ->header('X-Email-Sent-To', $user->email)
            ->with('password_success', 'Código de verificação enviado para ' . $user->email);
    }

    public function passwordResend()
    {
        $sentAt = session('bank_password_code_sent_at', 0);

        // Só permite reenvio após 30 segundos
        if (time() - $sentAt < 30) {
            return back()->with('password_error', 'Aguarde 30 segundos para reenviar.');
        }

        $user = BankUser::find(session('bank_user_id'));

        // Gera novo código
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            'bank_password_code' => $code,
            'bank_password_code_sent_at' => time(),
            'bank_password_expires_at' => time() + 300,
        ]);

        // VULNERABILIDADE: código exposto novamente no header
        return back()
            ->header('X-Verification-Code', $code)
            ->header('X-Email-Sent-To', $user->email)
            ->with('password_success', 'Novo código enviado para ' . $user->email);
    }

    public function passwordCancel()
    {
        session()->forget([
            'bank_password_code',
            'bank_password_code_sent',
            'bank_password_code_sent_at',
            'bank_password_expires_at',
            'bank_new_password',
        ]);

        return back()->with('password_success', 'Solicitação cancelada.');
    }

    public function passwordConfirm(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        // Verifica expiração (5 min)
        $expiresAt = session('bank_password_expires_at', 0);
        if (time() > $expiresAt) {
            session()->forget(['bank_password_code', 'bank_password_code_sent', 'bank_password_code_sent_at', 'bank_password_expires_at', 'bank_new_password']);
            return back()->with('password_error', 'Código expirado. Solicite um novo.');
        }

        $storedCode = session('bank_password_code');

        if ($request->code !== $storedCode) {
            return back()->with('password_error', 'Código inválido. Tente novamente.');
        }

        $user = BankUser::find(session('bank_user_id'));
        $user->password = Hash::make(session('bank_new_password'));
        $user->save();

        // Limpa sessão do fluxo
        session()->forget(['bank_password_code', 'bank_password_code_sent', 'bank_password_code_sent_at', 'bank_password_expires_at', 'bank_new_password']);

        return back()->with('password_success', 'Senha alterada com sucesso! FLAG{intercepted_verification_code_7e2a}');
    }
}
