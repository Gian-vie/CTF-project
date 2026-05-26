<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BankAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('bank_user_id')) {
            return redirect()->route('bank.login');
        }

        return $next($request);
    }
}
