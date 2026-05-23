<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JudgeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::select('id', 'title', 'category', 'points')->get();
        return view('judge', compact('challenges'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'challenge_id' => 'required|exists:challenges,id',
            'flag' => 'required|string|max:500',
        ]);

        $challenge = Challenge::findOrFail($request->challenge_id);

        $isCorrect = hash_equals($challenge->flag, $request->flag);

        // Verifica se o time já resolveu este desafio
        $alreadySolved = Submission::where('team_name', $request->team_name)
            ->where('challenge_id', $challenge->id)
            ->where('is_correct', true)
            ->exists();

        if ($alreadySolved) {
            return back()->with('warning', 'Seu time já resolveu este desafio!');
        }

        Submission::create([
            'team_name' => $request->team_name,
            'challenge_id' => $challenge->id,
            'submitted_flag' => $request->flag,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            return back()->with('success', "Flag correta! +{$challenge->points} pontos para {$request->team_name}!");
        }

        return back()->with('error', 'Flag incorreta. Tente novamente.');
    }
}
