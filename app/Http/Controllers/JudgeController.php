<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JudgeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $challenges = Challenge::select('id', 'title', 'category', 'points')->get();
        return view('judge', compact('challenges'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'challenge_id' => 'required|exists:challenges,id',
            'flag' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $challenge = Challenge::findOrFail($request->challenge_id);

        $isCorrect = hash_equals($challenge->flag, $request->flag);

        // Verifica se o usuário já resolveu este desafio
        $alreadySolved = Submission::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->where('is_correct', true)
            ->exists();

        if ($alreadySolved) {
            return back()->with('warning', 'Você já resolveu este desafio!');
        }

        Submission::create([
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'submitted_flag' => $request->flag,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            return back()->with('success', "Flag correta! +{$challenge->points} pontos!");
        }

        return back()->with('error', 'Flag incorreta. Tente novamente.');
    }
}
